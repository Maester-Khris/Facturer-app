<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
   use HasFactory;
   protected $fillable=['depot_id', 'libelle','numero_caisse'];


   public function depot()
   {
      return $this->belongsTo(Depot::class);
   }

   public function comptoirs()
   {
      return $this->hasMany(Comptoir::class);
   }
}
