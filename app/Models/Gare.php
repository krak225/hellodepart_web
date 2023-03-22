<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gare extends Model
{
    use HasFactory;

    protected $table      = "voygare";
    protected $primaryKey = "gare_id";
    protected $fillable = [
        'compagnie_id', 
        'gare_designation',
        'gare_nom_responsable',
        'gare_phone_bureau',
        'gare_numero_mobile',
        'gare_numero_fax',
        'gare_email',
        'gare_adresse_eographique',
        'gare_date_creation',
        'gare_date_modification',
        'gare_date_suppression',
    ];
    public $timestamps    = false;
}
