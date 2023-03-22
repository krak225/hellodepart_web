<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTransaction extends Model
{
    use HasFactory;

    protected $table      = "voytypetransaction";
    protected $primaryKey = "type_transaction_id";
    protected $fillable = [
        'type_transaction_libelle', 
        'type_transaction_nbre_jours',
        'type_transaction_montant',
        'type_transaction_date_debut_effet',
        'type_transaction_date_fin_effet',
        'type_transaction_statut'
    ];
    public $timestamps    = false;
}
