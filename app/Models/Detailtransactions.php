<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailtransactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference_transaction',
        'reference_marchandise',
        'quantite',
        'prix'
    ];
}
