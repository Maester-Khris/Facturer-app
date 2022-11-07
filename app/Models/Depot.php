<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DepotTrait;

class Depot extends Model
{
    use HasFactory;
    use DepotTrait;
    protected $fillable=['nom_depot','telephone','delai_reglement'];

    public function stock(){
        return $this->hasOne(Stockdepot::class);
    }

    public function personnels()
   {
      return $this->hasMany(Personnel::class);
   }

   public function clients()
   {
      return $this->hasMany(Client::class);
   }

   public function fournisseurs()
   {
      return $this->hasMany(Fournisseur::class);
   }

   public function caisses()
   {
      return $this->hasMany(Caisse::class);
   }

   public function comptoirs()
   {
      return $this->hasMany(Comptoir::class);
   }
}
