<?php

namespace App\Exports;

use App\Models\Facture;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class PDVFacturesExport implements FromCollection, WithHeadings
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
            "GAINS", 
            "STATUT", 
            "DATE DE PAIEMENT"
        ];
    }
}
