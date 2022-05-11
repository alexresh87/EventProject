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

    public function index(Request $request){

        //Всего записей в таблице
        $count_orders = Order::count();

        //Строка для поиска по таблице
        $search = $request->query('search', "");
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

    public function create(){
        return view('orders.create')
            ->with("route_name", self::ROUTE_ORDER_INSERT);
    }

    public function store(OrderRequest $request){

        $order = new Order();

        $order->firstname = trim($request->input('firstname'));
        $order->lastname = trim($request->input('lastname'));
        $order->patronymic = trim($request->input('patronymic'));
        $order->city = trim($request->input('city'));
        $order->address = trim($request->input('address'));
        $order->phone = preg_replace('~\D+~','', trim($request->input('phone')));
        $order->email = trim($request->input('email'));
        
        $order->save();

        return redirect()
            ->route('home')
            ->with('success_message','Заявка была принята');
    }

    public function update($id){

        $order = Order::find($id);
        return view('orders.update')
            ->with([
                'order' => $order,
                'route_name' => self::ROUTE_ORDER_UPDATE
            ]);
    }

    public function updateSubmit($id, OrderRequest $request){
        $order = Order::find($id);
        
        $order->firstname = $request->input('firstname');
        $order->lastname = $request->input('lastname');
        $order->patronymic = $request->input('patronymic');
        $order->city = $request->input('city');
        $order->address = $request->input('address');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');
        
        $order->save();

        return redirect()
            ->route('order.get')
            ->with('success_message','Запись была обновлена');
    }
}
