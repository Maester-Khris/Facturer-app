<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FournisseurTrait;

class Fournisseur extends Model
{
    use HasFactory;
    use FournisseurTrait;

    public function factures(){
        return $this->hasMany(Facture::class);
    }

    public function compte() { 
        return $this->hasOne(Comptefournisseur::class);
    }
    
}
