<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mouvementstock extends Model
{
    use HasFactory;

    public function marchandise(){
        return $this->hasOne(Marchandise::class);
    }
}
