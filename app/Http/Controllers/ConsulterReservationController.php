<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Ligne;
use PDF;

class ConsulterReservationController extends Controller
{
    //Formulaire de consultation de sa réservation
    public function ConsulterReservation(){

        return view('consulterreservation');
    }

    //Consultation
    public function Consultation(Request $request){

        $request->validate([
            'n' => ['required', 'string', 'max:255'],       
        ]);

        $numero_saisie = $request->n;
		
		$whereRaw = ' 1 ';

        // if(!empty($numero_saisie)){
            // $whereRaw.= " AND client.client_code = $numero_saisie ";
        // }

		$numero_embarquement = Client::join('facture', 'facture.client_id', '=', 'client.client_id')
							->where('facture.facture_statut_paiement', '=', "PAYE")
							->whereRaw('date(client.client_datedepart) >= ?', [gmdate("Y-m-d")])
							->orwhereRaw($whereRaw)
							->where('client.client_code', '=', $numero_saisie)
							->first();
	
		if($numero_embarquement){
			
			$destination = Client::join('facture', 'facture.client_id', '=', 'client.client_id')
								->join('voydepart', 'voydepart.depart_id', '=', 'facture.depart_id')
								->join('voyligne', 'voyligne.ligne_id', '=', 'voydepart.ligne_id')
								->where('facture.facture_statut_paiement', '=', "PAYE")
								->whereRaw('date(client.client_datedepart) >= ?', [gmdate("Y-m-d")])
								->orwhereRaw($whereRaw)
								->where('client.client_code', '=', $numero_saisie)
								->first();
							
            return view('numeroembarquement',['numero_embarquement'=>$numero_embarquement, 'destination'=>$destination]);
		
		}else{
			
			return back()->with('info_warning',"Le numéro que vous avez saisi ne correspond à aucun numéro d'embarquement payé");
		}          
    } 

    //Imprimer son ticket
    public function ImprimerTicket($facture_id){

        $facture = Facture::find($facture_id);
        
        $client = Client::where(['client_id'=>$facture->client_id])->first();
        
        $information = Ligne::join('voydepart','voydepart.ligne_id','voyligne.ligne_id')
                                ->join('voyage','voyage.voyage_id','voydepart.voyage_id')
                                ->join('voyvehicule','voyvehicule.vehicule_id','voyage.vehicule_id')
                                ->join('voycompagnie','voycompagnie.compagnie_id','voyvehicule.compagnie_id')
                                ->join('voygare','voygare.compagnie_id','voycompagnie.compagnie_id')
                                ->where(['depart_statut'=>"VALIDE", 'voydepart.depart_id'=>$facture->depart_id])
                                ->first();

        $compagnie_logo = 'https://www.hellodepart.com/assets/images/'.$information->compagnie_logo;

        $pdf = PDF::loadView('imprimerticket', compact('facture','client','information','compagnie_logo'));
        
        return $pdf->download('ticket.pdf');
    } 
}
