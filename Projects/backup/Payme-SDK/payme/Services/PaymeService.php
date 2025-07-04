<?php

namespace Payme\Services;

use Payme\Models\PaymeTransaction;

class PaymeService
{
    protected $app;
    protected $request;
    protected $transaction;

    public function __construct($app, $request, $transaction = null)
    {
        $this->app = $app;
        $this->request = $request;
        $this->transaction = $transaction;
    }
}