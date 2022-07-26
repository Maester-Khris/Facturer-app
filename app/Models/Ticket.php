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
        'code_ticket',
        'comptoir_id',
        'client_id',
        'total',
        'statut',
        'date_operation'
    ];

    public function comptoir()
    {
       return $this->belongsTo(Comptoir::class);
    }

}
