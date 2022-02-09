<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address'];

    public function closures()
    {
        return $this->hasMany(Closure::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
