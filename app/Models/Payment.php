<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'customer_id', 'to_pay',
        'start_period', 'end_period'
    ];

    public function paymentitems()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
