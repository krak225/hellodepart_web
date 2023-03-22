<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ville;
use App\Models\Ligne;
use App\Models\Depart;
use App\Models\Compagnie;
use App\Models\Voyage;
use App\Models\Gare;
use App\Models\Vehicule;
use App\Models\User;

class AccueilController extends Controller
{
    //Page d'accueil
	public function welcome(){
		
		$villes = Ville::where(['ville_statut'=>"VALIDE"])->orderby('ville_libelle')->get();
		
		return view('welcome',['villes'=>$villes]);
	}
	
	//Page d'accueil
	public function accueil(){
		
		$villes = Ville::where(['ville_statut'=>"VALIDE"])->orderby('ville_libelle')->get();
		
		return view('welcome',['villes'=>$villes]);	
	}
	
	//Page du résultats de recherche
	public function resultat(Request $request){
		$request->validate([
			'v' => ['required', 'string', 'max:255'],		
			'd' => ['required', 'string', 'max:255'],		
			'dt' => ['required', 'string', 'max:255'],		
		]);
		
		$ville_depart = $request->v;
		$ville_destination = $request->d;
		$date_depart = $request->dt;
		// $compagnie_id = $request->compagnie_id;
		$heure_depart = gmdate('H:i:s');
		
		$depart_prevus = Ligne::join('voydepart','voydepart.ligne_id','voyligne.ligne_id')
								->join('voyage','voyage.voyage_id','voydepart.voyage_id')
								->join('voyvehicule','voyvehicule.vehicule_id','voyage.vehicule_id')
								->join('voycompagnie','voycompagnie.compagnie_id','voyvehicule.compagnie_id')
								->join('voygare','voygare.compagnie_id','voycompagnie.compagnie_id')
								->where('ligne_ville_id_01', 'like', "%$ville_depart%")
								->where('ligne_ville_id_02', 'like', "%$ville_destination%")
								->where('depart_date_arrivee', 'like', "%$date_depart%")								
								->where('voydepart.depart_heure_arrivee','>=',$heure_depart)
								->where('voydepart.depart_capacitevehicule','>',0)
								->whereRaw('date(voydepart.depart_date_arrivee) >= "'.gmdate("Y-m-d").'" ')
								->orderBy('depart_date_arrivee','ASC')
								->orderBy('depart_tarif','ASC')
								->paginate(15);
								
		if(!empty($depart_prevus)){
			
			$villes = Ville::where(['ville_statut'=>"VALIDE"])->orderby('ville_libelle')->get();
			
			return view('resultat')->with(['depart_prevus'=>$depart_prevus,'villes'=>$villes, 'ville_depart_selected'=>$ville_depart, 'ville_destination_selected'=>$ville_destination, 'date_depart_selected'=>$date_depart]);
		}
	}

	//Formulaire de connexion
	public function SeConnecter(){

		return view('auth.login');	
	}
}
