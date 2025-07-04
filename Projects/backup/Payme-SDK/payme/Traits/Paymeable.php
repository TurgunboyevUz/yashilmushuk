<?php

namespace Payme\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Payme\Models\PaymeTransaction;
use Payme\Utils\Payme;

trait Paymeable
{
    public function payme_transaction(): HasOne
    {
        return $this->hasOne(PaymeTransaction::class, 'owner_id', 'id');
    }

    public function payme_app()
    {
        return $this->payme_app ?? config('payme.default');
    }

    public function payme($amount = null): Payme
    {
        return new Payme($this, $amount);
    }
}