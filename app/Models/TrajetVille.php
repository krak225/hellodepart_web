<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrajetVille extends Model
{
    use HasFactory;

    protected $table      = "voytrajetville";
    protected $primaryKey = "trajetville_id";
    protected $fillable = [
        'trajet_id', 
        'ville_id',
        'trajet_numero_ordre'
    ];
}
