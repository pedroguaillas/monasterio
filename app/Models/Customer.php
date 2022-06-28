<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'user_id', 'schedule_id',
        'identification', 'first_name', 'last_name',
        'gender', 'alias', 'date_of_birth',
        'phone', 'photo', 'finger', 'payment_method_id'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
