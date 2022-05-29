<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\DTO\OrderFormDTO;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    const DEFAULT_ORDERS_PER_PAGE = 10;
    const ROUTE_ORDER_INSERT = 'order.store';
    const ROUTE_ORDER_UPDATE = 'order.updateSubmit';

    /**
     * Вывод списка заявок для менеджера из личного кабинета
     */
    public function index(Request $request)
    {

        //Всего записей в таблице
        $count_orders = Order::count();

        //Строка для поиска по таблице
        $search = $request->query('search', "");

        //Если строка не пустая, то ищем по всем столбцам совпадение
        if ($search) {
            $search_str = '%' . $search . '%';
            $orders = Order::where('lastname', 'LIKE', $search_str)
                ->orWhere('firstname', 'LIKE', $search_str)
                ->orWhere('patronymic', 'LIKE', $search_str)
                ->orWhere('city', 'LIKE', $search_str)
                ->orWhere('address', 'LIKE', $search_str)
                ->orWhere('phone', 'LIKE', $search_str)
                ->orWhere('email', 'LIKE', $search_str)
                ->orderBy('created_at', 'desc');
        } else {
            $orders = Order::orderBy('created_at', 'desc');
        }

        //Разбиваем вывод по DEFAULT_ORDERS_PER_PAGE записей
        $orders = $orders->paginate(self::DEFAULT_ORDERS_PER_PAGE);

        return view('orders.list', [
            'orders' => $orders,
            'count_orders' => $count_orders,
            'search' => $search
        ]);
    }

    /**
     * Получение количество заявок по дням в заданном месяце
     * Возвращает json
     */
    public function getCountByMonth($year, $month, OrderService $orderService)
    {
        return response()->json([
            'status' => 'success',
            'data' => $orderService->getCountByMonth($year, $month)
        ]);
    }

    /**
     * Страница создания заявки для guest
     */
    public function create()
    {
        return view('orders.create')
            ->with("route_name", self::ROUTE_ORDER_INSERT);
    }


    /**
     * Добавление заявки для guest
     */
    public function store(OrderRequest $request, OrderService $orderService)
    {
        $orderData = new OrderFormDTO($request->validated());

        $orderService->storeOrder($orderData);

        return redirect(route('home'))->with('success_message', 'Заявка была принята');
    }

    /**
     * Страница обновления заявки для менеджера
     */
    public function update($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.update')
            ->with([
                'order' => $order,
                'route_name' => self::ROUTE_ORDER_UPDATE
            ]);
    }

    /**
     * Обновление заявки для менеджера
     */
    public function updateSubmit($id, OrderRequest $request, OrderService $orderService)
    {
        $orderService->updateOrder($id, new OrderFormDTO($request->validated()));

        return redirect(route('order.get'))->with('success_message', 'Запись была обновлена');
    }
}
