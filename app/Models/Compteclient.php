<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CompteclientTrait;

class Compteclient extends Model
{
    use HasFactory;
    use CompteclientTrait;

    protected $fillable = [
        'client_id',
        'debit',
        'credit',
        'date_debit',
        'date_credit'
    ];
}
