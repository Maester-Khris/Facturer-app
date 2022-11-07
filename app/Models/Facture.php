<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FactureTrait;

class Facture extends Model
{
    use HasFactory;
    use FactureTrait;

    protected $appends = ['reste_facture',];
    protected $fillable = [
        'fournisseur_id',
        'code_facture',
        'montant_total',
        'montant_remise',
        'montant_net',
        'date_facturation'
    ];

    public function getResteFactureAttribute(){
        $totalfac = Journalachat::getMontantFacture($this->id);
        $libele = 'Reglement facture '. $this->code_facture;
        $montant = Detailcompte::where('reference_operation',$libele)->sum('credit');
        $deja_paye = $montant != null ? $montant : 0;
        // $deja_paye = Comptecaisse::MontantReglementFacture($this->code_facture);
        return ($totalfac - $deja_paye);
    }

    // public function getFournisseurAttribute(){
    //     return $this->fournisseur->nom;
    // }

    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class);
    }

    public function journal() { 
        return $this->hasOne(Journalachat::class);
    }
}
