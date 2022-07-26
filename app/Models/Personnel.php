<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PersonnelTrait;

class Personnel extends Model
{
    use HasFactory;
    use PersonnelTrait;
    protected $fillable=
    ['nom_complet','sexe','telephone',
    'email','cni','date_embauche','type_contrat',
    'poste','matricule','matricule_cnps','depot_id'
    ];

    public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function comptoir()
   {
      return $this->hasOne(Comptoir::class);
   }

   public function depot()
   {
      return $this->belongsTo(Depot::class);
   }
}
