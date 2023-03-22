<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table      = "voytarif";
    protected $primaryKey = "tarif_id";
    protected $fillable = [
        'ligne_id', 
        'compagnie_id',
        'tarif_ville_id_01',
        'tarif_ville_id_02',
        'tarif_montant',
        'tarif_frais_service',
        'tarif_date_valeur_debut',
        'tarif_date_valeur_fin',
        'tarif_date_creation',
        'tarif_date_systeme'
    ];
    public $timestamps    = false;
}
