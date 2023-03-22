<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
	
	protected $table="voyclient";
    protected $primaryKey="client_id";
    protected $fillable=[
        'client_nom',
        'client_prenoms',
        'client_email'
    ];
    public $timestamps = false;
}
