<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosureItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'closure_id', 'description', 'date', 'debit', 'have'
    ];
}
