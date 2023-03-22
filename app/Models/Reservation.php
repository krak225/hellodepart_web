<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table      = "voyreservation";
    protected $primaryKey = "reservation_id";
    protected $fillable = [
        'user_id', 
        'facture_id', 
        'depart_ville_id',
        'reservation_date_valeur',
        'reservation_date_depart_prevue',
        'reservation_date_depart_reel',
        'reservation_montant_total',
        'reservation_nom_prenoms_passager',
        'reservation_mobile_passager',
        'reservation_date_creation',
        'reservation_date_modification',
        'reservation_date_suppression',
        'reservation_date_systeme'
    ];
    public $timestamps    = false;
	
	// Relation entre Réservation et Facture
	public function facture(){

        return $this->belongsTo(Facture::class, 'facture_id');

    }  
}
