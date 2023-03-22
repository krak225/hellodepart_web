<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    use HasFactory;

    protected $table      = "voytrajet";
    protected $primaryKey = "trajet_id";
    protected $fillable = [
        'trajet_depart', 
        'trajet_arrive',
        'trajet_statut'
    ];
}
