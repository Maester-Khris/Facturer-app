<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marchandise extends Model
{
    use HasFactory;

    protected $fillable=[
        'reference','designation','prix_achat','dernier_prix_achat',
        'prix_vente_detail','prix_vente_gros', 'unite_achat',
        'cmup', 'conditionement', 'quantité_conditionement'
    ];

    public function mouvements(){
        return $this->hasMany(Mouvementstock::class);
    }

    public function inventoriers(){
        return $this->hasMany(Inventaire::class);
    }
}
