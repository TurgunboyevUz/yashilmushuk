<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $order = Order::create([]);
    $transaction = $order->createMirpayTransaction(15000, 'Order #'.$order->id);

    dd($order->checkoutMirpayTransaction());
});
