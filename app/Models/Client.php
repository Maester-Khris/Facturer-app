<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ClientTrait;

class Client extends Model
{
    use HasFactory;
    use ClientTrait;

    public function ventes() { 
        return $this->hasMany(Ticket::class);
    }
}
