<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ClientTrait;

class Client extends Model
{
    use HasFactory;
    use ClientTrait;
    protected $fillable=['nom_complet','telephone','tarification_client'];

    public function tickets() { 
        return $this->hasMany(Ticket::class);
    }

    public function depot()
   {
      return $this->belongsTo(Depot::class);
   }

   public function personnels()
   {
      return $this->hasMany(Personnel::class);
   }
}
