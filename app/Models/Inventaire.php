<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\InventaireTrait;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;
    use InventaireTrait;

    protected $fillable=['stockdepot_id','marchandise_id','ancienne_quantite','quantite_reajuste','difference','date_reajustement'];

    public function marchandise(){
        return $this->belongsTo(Marchandise::class);
    }
}
