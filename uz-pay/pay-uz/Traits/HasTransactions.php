<?php
namespace PayUz\Traits;

use App\Models\Transaction;

trait HasTransactions
{
    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
