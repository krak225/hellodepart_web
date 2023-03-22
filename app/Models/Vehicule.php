<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $table      = "voyvehicule";
    protected $primaryKey = "vehicule_id";
    protected $fillable = [
        'compagnie_id', 
        'vehicule_numero',
        'vehicule_immatriculation',
        'vehicule_marque',
        'vehicule_modele',
        'vehicule_nombre_place',
        'vehicule_image',
        'vehicule_date_creation',
        'vehicule_date_modification',
        'vehicule_date_suppression',
        'vehicule_statut'
    ];
    public $timestamps    = false;
}
