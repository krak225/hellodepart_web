<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $table="voyfacture";
    protected $primaryKey="facture_id";
    protected $fillable=[
        'user_id',
        'client_id',
        'facture_montant',
        'facture_numero',
        'facture_statut_paiement'
    ];
    public $timestamps = false;
	
	// Relation entre Facture et Réservation
	public function reservations(){
		
		return $this->hasMany(Reservation::class, 'reservation_id','reservation_id');
	
	}
}
