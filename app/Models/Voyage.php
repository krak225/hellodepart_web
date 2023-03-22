<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    use HasFactory;

    protected $table="voyage";
    protected $primaryKey="voyage_id";
    protected $fillable=[
        'vehicule_id',
        'trajet_id',
        'gare_id',
        'compagnie_id',
        'voyage_ville_depart_id',
        'voyage_ville_arrivee_id',
        'voyage_numero_journee',
        'voyage_date_heure_depart_prevue',
        'voyage_date_heure_arrivee_prevue',
        'voyage_date_heure_depart_reelle',
        'voyage_date_heure_arrivee_reelle',
        'voyage_date_creation',
        'voyage_date_modification',
        'voyage_date_suppression'
    ];
    public $timestamps = false;
}
