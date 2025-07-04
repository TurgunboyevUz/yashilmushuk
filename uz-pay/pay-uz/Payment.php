<?php

namespace PayUz;

class Payment
{
    public const CLICK = 'click';
    public const PAYME = 'payme';

    public $model;
    public $paysys;

    public function __construct($model, $paysys = null)
    {
        $this->model = $model;
        $this->paysys = $paysys;
    }

    public function redirect($amount)
    {
        return route('payment.redirect', [
            'paysys' => $this->paysys,
            'key' => $this->model->getKey(),
            'data' => $amount,
        ]);
    }
}