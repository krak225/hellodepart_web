<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationReglement extends Model
{
    use HasFactory;

    protected $table      = "voyreservationreglement";
    protected $primaryKey = "reservation_reglement_id";
    protected $fillable = [ 
        'timbre_id',
        'reservation_id',
        'type_transaction_id',
        'reservation_reglement_date_valeur',
        'reservation_reglement_timbre_etat',
        'reservation_reglement_montant',
        'reservation_reglement_date_creation'
    ];
    public $timestamps    = false;
}
