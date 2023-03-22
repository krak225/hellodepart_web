<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{
    use HasFactory;

    protected $table = "voyligne";
    protected $primaryKey = "ligne_id";
    protected $fillable = [
        'trajetville_id_01',
        'trajetville_id_02',
        'trajet_id_01',
        'trajet_id_02',
        'ligne_ville_id_01',
        'ligne_ville_id_02',
        'ligne_designation'
    ];
    public $timestamps = false;


    public function compagnie()
    {
        return $this->belongsTo(Compagnie::class, 'compagnie_id');
    }

    

}
