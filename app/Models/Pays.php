<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;

    protected $table      = "voypays";
    protected $primaryKey = "pays_id";
    protected $fillable = [
        'pays_code', 
        'pays_nom',
        'pays_nationnalite',
        'pays_date_creation'
    ];
    public $timestamps    = false;
}
