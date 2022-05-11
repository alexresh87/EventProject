<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    const DEFAULT_ORDERS_PER_PAGE = 10;
    const ROUTE_ORDER_INSERT = 'order.store';
    const ROUTE_ORDER_UPDATE = 'order.updateSubmit';

    /**
     * Вывод списка заявок для менеджера из личного кабинета
     */
    public function index(Request $request){

        //Всего записей в таблице
        $count_orders = Order::count();

        //Строка для поиска по таблице
        $search = $request->query('search', "");

        //Если строка не пустая, то ищем по всем столбцам совпадение
        if($search){
            $search_str = '%'.$search.'%';
            $orders = Order::where('lastname','LIKE', $search_str)
                        ->orWhere('firstname','LIKE', $search_str)
                        ->orWhere('patronymic','LIKE', $search_str)
                        ->orWhere('city','LIKE', $search_str)
                        ->orWhere('address','LIKE', $search_str)
                        ->orWhere('phone','LIKE', $search_str)
                        ->orWhere('email','LIKE', $search_str)
                        ->orderBy('created_at','desc');
        }else{
            $orders = Order::orderBy('created_at','desc');
        }

        //Разбиваем вывод по DEFAULT_ORDERS_PER_PAGE записей
        $orders = $orders->paginate(self::DEFAULT_ORDERS_PER_PAGE);

        return view('orders.list',[
            'orders' => $orders,
            'count_orders' => $count_orders,
            'search' => $search
        ]);
    }

    /**
     * Получение количество заявок по дням в заданном месяце
     * Возвращает json
     */
    public function getCountByMonth($year, $month){
        $orders = DB::table('orders')
             ->select(DB::raw('DAYOFMONTH(created_at) as day, COUNT(id) as counts'))
             ->whereRaw( sprintf('MONTH(created_at) = %d AND YEAR(created_at) = %d', $month, $year))
             ->groupByRaw('DAYOFMONTH(created_at)')
             ->orderByRaw('DAYOFMONTH(created_at) ASC')
             ->get();

        $days_in_month = [31,28,31,30,31,30,31,31,30,31,30,31];
        if($year%4 == 0){
            $days_in_month[1] = 29;
        }
        $ret_arr = [];
        for($i = 0; $i < $days_in_month[$month-1]; $i++){
            $ret_arr[$i+1] = 0;
        }
        foreach($orders as $order){
            $ret_arr[$order->day] = $order->counts;
        }
        return json_encode(array_values($ret_arr));
    }

    /**
     * Страница создания заявки для guest
     */
    public function create(){
        return view('orders.create')
            ->with("route_name", self::ROUTE_ORDER_INSERT);
    }


    /**
     * Добавление заявки для guest
     */
    public function store(OrderRequest $request){

        $order = new Order();

        //Заполняем все поля
        $order->firstname = trim($request->input('firstname'));
        $order->lastname = trim($request->input('lastname'));
        $order->patronymic = trim($request->input('patronymic'));
        $order->city = trim($request->input('city'));
        $order->address = trim($request->input('address'));
        $order->phone = preg_replace('~\D+~','', trim($request->input('phone')));
        $order->email = trim($request->input('email'));
        
        //Добавляем в базу
        $order->save();

        //Переадресация на главную страницу 
        return redirect()
            ->route('home')
            ->with('success_message','Заявка была принята');
    }

    /**
     * Страница обновления заявки для менеджера
     */
    public function update($id){

        $order = Order::find($id);
        return view('orders.update')
            ->with([
                'order' => $order,
                'route_name' => self::ROUTE_ORDER_UPDATE
            ]);
    }

    /**
     * Обновление заявки для менеджера
     */
    public function updateSubmit($id, OrderRequest $request){
        $order = Order::find($id);

        //Обновляем все поля
        $order->firstname = $request->input('firstname');
        $order->lastname = $request->input('lastname');
        $order->patronymic = $request->input('patronymic');
        $order->city = $request->input('city');
        $order->address = $request->input('address');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');
        
        //Сохраняем изменения
        $order->save();

        //Переходим к списку заявок с сообщением об успешном редактировании
        return redirect()
            ->route('order.get')
            ->with('success_message','Запись была обновлена');
    }
}
