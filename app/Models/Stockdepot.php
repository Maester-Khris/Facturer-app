<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\StockdepotTrait;

class Stockdepot extends Model
{
    use HasFactory;
    use StockdepotTrait;

    // date derniere misae a jour doit etre nullable: pour quand on cree un stock
    protected $fillable=['depot_id','marchandise_id','quantite_stock','qte_derniere_modif'];

    public function depot(){
      return $this->belongsTo(Depot::class);
   }

   public function mouvements(){
    return $this->hasMany(Mouvementstock::class);
   }

    // lorsqu'on cree un stock on copie tout les articles existant dans celui ci avec les quantité intialies
    // qte optimal:
    // qte en physique et qté machine: 0
    // seuil: valuer initial
    // enlever sur le template (qte physique et machine), conserver juste qute stock
   public function marchandises(){
    return $this->hasMany(Marchandise::class);
   }

    // un reajustement de stock est enregistre comme sorti
    // mais est aussi ajoute comme ligne dans inventaire
    public function inventaires(){
        return $this->hasMany(Inventaire::class);
    }
}
