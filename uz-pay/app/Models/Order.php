<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PayUz\Traits\HasTransactions;

class Order extends Model
{
    protected $guarded = [];

    use HasTransactions;
}
