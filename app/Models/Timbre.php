<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timbre extends Model
{
    use HasFactory;

    protected $table      = "voytimbre";
    protected $primaryKey = "timbre_id";
    protected $fillable = [
        'timbre_montant_min', 
        'timbre_montant_max',
        'timbre_valeur',
        'timbre_date_debut_effet',
        'timbre_date_fin_effet',
        'timbre_statut'
    ];
    public $timestamps    = false;
}
