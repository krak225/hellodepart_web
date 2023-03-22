<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compagnie extends Model
{
    use HasFactory;
    protected $table="voycompagnie";
    protected $primaryKey="compagnie_id";
    protected $fillable=[
        'compagnie_designation',
        'compagnie_representant',     
        'compagnie_adresse_siege',        
        'compagnie_phone_bureau',     
        'compagnie_mobile',       
        'compagnie_fax',      
        'compagnie_bp',       
        'compagnie_email',        
        'compagnie_date_creation' 
    ];
    public $timestamps = false;
}
