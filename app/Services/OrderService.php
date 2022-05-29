<?php

namespace App\Services;

use App\Models\Order;
use App\DTO\OrderFormDTO;

class OrderService
{
    public function storeOrder(OrderFormDTO $orderForm){
        return Order::create($orderForm->all());
    }
}
