<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $table      = "voyville";
    protected $primaryKey = "ville_id";
    protected $fillable = [
        'pays_id', 
        'ville_libelle', 
        'ville_description',
        'ville_date_creation',
        'ville_date_modification',
        'ville_date_suppression',
        'ville_date_systeme',
        'ville_statut'
    ];
    public $timestamps    = false;
}
