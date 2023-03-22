<?php

namespace App\Exports;

use App\Models\Facture;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class FacturesExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return Facture::select("client_code",'client_nom','client_prenoms', 'client_telephone', 'ligne_designation', 'facture_nbr_ticket', "facture_montant", "facture_date_paiement")
                        ->join('voyclient','voyclient.client_id','voyfacture.client_id')
                        ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
                        ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                        ->join('voycompagnie','voycompagnie.compagnie_id','voyligne.compagnie_id')
                        ->where(['voycompagnie.compagnie_id'=>Auth::user()->compagnie_id,'facture_statut_paiement'=>"PAYE"])
                        ->whereRaw('date(facture_date_paiement) = "'.gmdate("Y-m-d").'" ')
                        ->orderby('facture_id','DESC')
                        ->get();
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
            "DATE DE PAIEMENT"
        ];
    }
}
