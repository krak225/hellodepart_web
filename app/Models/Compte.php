<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    protected $table="voycompte";
    protected $primaryKey="compte_id";
    protected $fillable=[
        'user_id',
        'reservation_id',
        'compte_reference',
        'compte_solde'
    ];
    public $timestamps = false;
}
