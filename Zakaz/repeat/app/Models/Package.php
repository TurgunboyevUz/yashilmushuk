<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TurgunboyevUz\Mirpay\Traits\HasMirpayTransactions;

class Package extends Model
{
    use HasMirpayTransactions;

    protected $guarded = [];
}
