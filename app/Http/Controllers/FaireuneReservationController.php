<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ville;
use App\Models\TrajetVille;
use App\Models\Trajet;
use App\Models\Compagnie;
use App\Models\Voyage;
use App\Models\Gare;
use App\Models\Vehicule;
use App\Models\Depart;
use App\Models\Facture;
use App\Models\Compte;
use App\Models\Reservation;
use App\Models\Ligne;

class FaireuneReservationController extends Controller
{
    //Information sur la réservation
    public function FaireReservation($depart_id){
        
        $reservation = Depart::where(['depart_id'=>$depart_id, 'depart_statut'=>'VALIDE'])->first();
    
        $itineraires = Depart::join('voyage','voyage.voyage_id','voydepart.voyage_id')
                                ->join('voytrajet','voytrajet.trajet_id','voyage.trajet_id')
                                ->join('voytrajetville','voytrajetville.trajet_id','voytrajet.trajet_id')
                                ->join('voyville','voyville.ville_id','voytrajetville.ville_id')                                
                                ->where(['depart_id'=>$depart_id])
                                ->orderBy('trajet_numero_ordre')
                                ->get();


        return view('reservation', ['reservation'=>$reservation]);
    }
}
