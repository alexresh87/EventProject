<?php

namespace App\Services;

use App\Models\Order;
use App\DTO\OrderFormDTO;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function storeOrder(OrderFormDTO $orderForm)
    {
        return Order::create($orderForm->all());
    }

    public function updateOrder(int $id, OrderFormDTO $orderForm)
    {
        return Order::find($id)->update($orderForm->all());
    }

    public function getCountByMonth($year, $month): array
    {
        $orders = DB::table('orders')
            ->select(DB::raw('DAYOFMONTH(created_at) as day, COUNT(id) as counts'))
            ->whereRaw(sprintf('MONTH(created_at) = %d AND YEAR(created_at) = %d', $month, $year))
            ->groupByRaw('DAYOFMONTH(created_at)')
            ->orderByRaw('DAYOFMONTH(created_at) ASC')
            ->get();

        $days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if ($year % 4 == 0) {
            $days_in_month[1] = 29;
        }
        $ret_arr = [];
        for ($i = 0; $i < $days_in_month[$month - 1]; $i++) {
            $ret_arr[$i + 1] = 0;
        }
        foreach ($orders as $order) {
            $ret_arr[$order->day] = $order->counts;
        }
        return array_values($ret_arr);
    }
}
