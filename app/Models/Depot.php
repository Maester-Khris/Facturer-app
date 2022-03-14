<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;
    protected $fillable=['nom_depot','telephone','delai_reglement'];

    public function stock(){
        return $this->hasOne(Stockdepot::class);
    }
}
