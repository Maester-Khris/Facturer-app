<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MouvementstockTrait;

class Mouvementstock extends Model
{
    use HasFactory;
    use MouvementstockTrait;

    // Note: un reajustement est un movement de sorti mais aussi une sorte d'inventaire pour 1 prod
        // -> creer une novelle ligne inventaire a chaque reajustement dans situation depot

    // la reference affiché est la reference du mouvement
    protected $fillable=['stockdepot_id','marchandise_id','reference_mouvement','type_mouvement','quantite_mouvement','date_operation'];

    public function marchandise(){
        return $this->belongsTo(Marchandise::class);
    }


}
