<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ComptoirTrait;

class Comptoir extends Model
{
    use HasFactory;
    use ComptoirTrait;
    protected $fillable=['depot_id','personnel_id','caisse_id','libelle'];

}
