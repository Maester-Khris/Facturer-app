<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ComptefournisseurTrait;

class Comptefournisseur extends Model
{
    use HasFactory;
    use ComptefournisseurTrait;

    protected $fillable = [
        'fournisseur_id',
        'debit',
        'credit',
        'date_debit',
        'date_credit'
    ];

    public function fournisseur() { 
        return $this->belongsTo(Fournisseur::class);
    }
    
    public function journals() { 
        return $this->hasMany(Journalachat::class);
    }
}
