<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailcompte extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero_compte',
        'reference_operation',
        'date_operation',
        'debit',
        'credit',
        'solde'
    ];
}
