<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depart extends Model
{
    use HasFactory;

    protected $table = "voydepart";
    protected $primaryKey = "depart_id";
    protected $fillable = [
        'voyage_id',
        'ligne_voyage_id',
        'depart_date_arrivee',
        'depart_heure_arrivee',
        'depart_date_delais_validite',
        'depart_nbre_ticket_achete',
        'depart_tarif',
        'depart_timbre_etat'
    ];
    public $timestamps = false;


    public function ligne()
    {
        return $this->belongsTo(Ligne::class, 'ligne_id');
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function compagnie()
    {
        return $this->belongsTo(Compagnie::class, 'compagnie_id');
    }

    public function gare()
    {
        return $this->belongsTo(Gare::class, 'gare_id');
    }

    public function timbre()
    {
        return $this->belongsTo(Timbre::class, 'timbre_id');
    }

}
