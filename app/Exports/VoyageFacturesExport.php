<?php

namespace App\Exports;

use App\Models\Facture;
use App\Models\Voyage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class VoyageFacturesExport implements FromCollection, WithHeadings
{
    protected $factures;

    public function __construct($factures)
    {
        $this->factures = $factures;
    }

    public function collection()
    {
        return $this->factures;
    }

    public function headings():array
    {
        return [
            "N° EMBARQUEMENT", 
            "NOM",
            "PRENOMS", 
            "TELEPHONE", 
            "DESTINATION", 
            "NOMBRE DE TICKET", 
            "MONTANT", 
            "STATUT", 
            "DATE DE PAIEMENT"
        ];
    }
}
