<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\JournalachatTrait;

class Journalachat extends Model
{
    use HasFactory;
    use JournalachatTrait;

    public function comptefournisseur() { 
        return $this->belongsTo(Comptefournisseur::class);
    }

    public function facture() { 
        return $this->belongsTo(Facture::class);
    }
}
