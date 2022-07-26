<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FournisseurTrait;

class Fournisseur extends Model
{
    use HasFactory;
    use FournisseurTrait;
    protected $fillable=['nom_complet','telephone','type_fournisseur'];

    public function factures(){
        return $this->hasMany(Facture::class);
    }

    public function compte() { 
        return $this->hasOne(Comptefournisseur::class);
    }

    public function depot()
   {
      return $this->belongsTo(Depot::class);
   }
    
}
