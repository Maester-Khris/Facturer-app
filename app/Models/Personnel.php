<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    protected $fillable=
    ['nom_complet','sexe','telephone',
    'email','cni','date_embauche','type_contrat',
    'poste','matricule','matricule_cnps','depot_id'
    ];
}
