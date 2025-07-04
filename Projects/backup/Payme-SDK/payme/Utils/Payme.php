<?php

namespace Payme\Utils;

class Payme
{
    private $amount;
    private $model;

    public function __construct($model, $amount)
    {
        $this->amount = $amount;
        $this->model = $model;
    }

    public function url()
    {
        return route('payme.redirect', [$this->amount, $this->model->id]);
    }

    public function invalidate()
    {
        return $this->model->payme_transaction()->update([
            'state' => -2
        ]);
    }
}