<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TicketTrait;

class Ticket extends Model
{
    use HasFactory;
    use TicketTrait;

    protected $fillable = [
        'vente_id',
        'marchandise_id',
        'quantite',
        'type_vente',
        'prix_vente',
    ];

}
