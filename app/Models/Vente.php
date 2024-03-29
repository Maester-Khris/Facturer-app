<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\VenteTrait;

class Vente extends Model
{
    use HasFactory;
    use VenteTrait;

    protected $appends = ['reste_vente',];
    protected $fillable = [
        'client_id',
        'code_vente',
        'montant_remise',
        'montant_total',
        'montant_net',
        'indicatif',
        'date_operation'
    ];

    public function getResteVenteAttribute(){
        // dd($this->id);
        $totalvente = Journalvente::getMontantFacture($this->id);
        // $deja_paye = Comptecaisse::MontantReglementVente($this->code_vente);
        $libele = 'Reglement vente '. $this->code_vente;
        $montant = Detailcompte::where('reference_operation',$libele)->sum('debit');
        $deja_paye = $montant != null ? $montant : 0;
        return ($totalvente - $deja_paye);
    }
    
    public function client() { 
        return $this->belongsTo(Client::class);
    }
}
