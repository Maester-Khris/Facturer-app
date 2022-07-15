<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MarchandiseTrait;

class Marchandise extends Model
{
    use HasFactory;
    use MarchandiseTrait;

    protected $fillable=[
        'reference','designation','prix_achat',
        'prix_vente_detail','prix_vente_gros', 'prix_vente_super_gros', 'unite_achat',
        'conditionement', 'quantité_conditionement'
    ];

    public function mouvements(){
        return $this->hasMany(Mouvementstock::class);
    }

    public function inventoriers(){
        return $this->hasMany(Inventaire::class);
    }

}
