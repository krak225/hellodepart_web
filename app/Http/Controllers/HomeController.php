<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Facture;
use App\Models\Gare;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
	 
    public function index()
    {
        if(Auth::user()->profil_id == 1){

            $compagnie = User::where(['profil_id'=>2])->count();
            $pdv = User::where(['profil_id'=>3])->count();
			
            return view('admin.home',['compagnie'=>$compagnie, 'pdv'=>$pdv]);

        }
        elseif(Auth::user()->profil_id == 2){

            //dd(Auth::user()->profil_id);

            $ticket_payes = Facture::join('voyclient','voyclient.client_id','voyfacture.client_id')
                                ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
                                ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                                ->join('voycompagnie','voycompagnie.compagnie_id','voyligne.compagnie_id')
                                ->where(['voycompagnie.compagnie_id'=>Auth::user()->compagnie_id,'facture_statut_paiement'=>"PAYE"])
                                ->whereRaw('date(facture_date_paiement) = "'.gmdate("Y-m-d").'" ')
                                ->orderby('facture_date_paiement','DESC')
                                ->get();
            //dd($ticket_payes); 
            $date_jours = gmdate('Y-m-d');

            return view('compagnie.home',['date_jours'=>$date_jours, 'ticket_payes'=>$ticket_payes]);

        }else{

            $factures = Facture::join('voyclient','voyclient.client_id','voyfacture.client_id')
                                ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
                                ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                                ->where(['voyfacture.user_id'=>Auth::user()->id])
                                ->whereRaw('date(facture_date_paiement) = "'.gmdate("Y-m-d").'" ')
                                ->orderby('facture_date_paiement','ASC')
								->get();

            return view('pointvente.home',['factures'=>$factures]); 
        }

	}
}
