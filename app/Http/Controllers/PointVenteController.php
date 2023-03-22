<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ville;
use App\Models\Ligne;
use App\Models\Depart;
use App\Models\Compagnie;
use App\Models\Facture;
use App\Models\Gare;
use App\Models\Vehicule;
use App\Models\ParametrageFrais;
use App\Models\User;
use App\Models\Client;
use App\Mail\AnnulerReservationMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Exports\PDVFacturesExport;
use Excel;
use PDF;
use View;
use DB;
use Dompdf\Dompdf;

class PointVenteController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    //Liste des réservation
    public function ListeReservation(){

        if(Auth::user()->profil_id == 3) {

            $factures = Facture::join('voyclient','voyclient.client_id','voyfacture.client_id')
        						->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
        						->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                                ->where(['voyfacture.user_id'=>Auth::user()->id])
								//->where('facture_statut_paiement', '!=', "ANNULE")
                                //->whereRaw('facture_statut_paiement <> "EN ATTENTE"')
                                ->orderby('facture_date_paiement','DESC')
								->get();
			// dd($factures);
            return view('pointvente.listereservation',['factures'=>$factures]);

        }else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
    }

    //Annuler une réservation
    public function AnnulerReservation(Request $request, $facture_id){

		if(Auth::user()->profil_id == 3) {

			$rules = [
                'deamnde' => 'required|string',
            ];

            $customMessages = [
                'deamnde.required'=>"Le Motif de la demande d'annulation est obligatoire",
            ];

            $this->validate($request,$rules,$customMessages);

			$facture = Facture::find($facture_id);

			if($facture){

				$pointvente = User::where(['users.id'=>$facture->user_id])->first();
				$client = Client::where(['voyclient.client_id'=>$facture->client_id])->first();

				$contact_data = [
					'nom' => $pointvente->nom,
					'prenoms' => $pointvente->prenoms,
					'email' => $pointvente->email,
					'facture' => $facture->facture_numero,
					'client_nom' => $client->client_nom,
					'client_prenoms' => $client->client_prenoms,
					'demande' => $request->demande,
					'adresse_ip'=> $_SERVER['REMOTE_ADDR'],
				];

				Mail::to('sales@hellodepart.com')->send(new AnnulerReservationMail($contact_data));

				$facture->facture_statut_paiement = "EN ATTENTE";
				$facture->exists = true;
				$facture->update();

				return back()->with('info_succes',"LA DEMANDE D'ANNULATION DE LA RÉSERVATION A BIEN ÉTÉ ENVOYÉE");
			}
		}else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
    }

	//Modifier mon compte
	public function ModifierMonCompte(){

		if(Auth::user()->profil_id == 3) {

			$villes = Ville::orderby('ville_libelle','ASC')->get();

			return view('pointvente.modifiercompte',['villes'=>$villes]);

		}else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
	}

	//Save Modifier Compte
	public function SaveModifierMonCompte(Request $request){

		if(Auth::user()->profil_id == 3) {

			$rules = [
                'nom' => 'required|string',
				'prenoms' => 'required|string',
				'ville_id' => 'required|string',
				'adresse' => 'required|string',
				'telephone' => 'required|numeric',
            ];

            $customMessages = [
                'nom.required'=>"Le nom est obligatoire",
                'prenoms.required'=>"Le prénoms est obligatoire",
                'ville_id.required'=>"La ville est obligatoire",
                'adresse.required'=>"L'adresse géographique est obligatoire",
                'telephone.required'=>"Le numéro de téléphone est obligatoire",
                'telephone.numeric'=>"Le numéro de téléphone est numérique",
            ];

            $this->validate($request,$rules,$customMessages);

			$user = User::where(['users.id'=>Auth::user()->id])->first();

			if($user){

				$user->nom 			= htmlspecialchars($request->nom);
				$user->prenoms 		= htmlspecialchars($request->prenoms);
				$user->ville_id 	= $request->ville_id;
				$user->telephone 	= htmlspecialchars($request->telephone);
				$user->adresse_geo 	= htmlspecialchars($request->adresse);
				$user->exists 		= true;
				$user->update();

				return redirect()->back()->with('info_succes',"Compte modifié avec succès !");
			}

		}else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
	}

	//Modifier mot de passe
	public function ChangerMotePasse(){

		if(Auth::user()->profil_id == 3) {

			return view('pointvente.changermotpasse');

		}else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
	}

	//Save modifier mot de passe
	public function SaveChangerMotePasse(Request $request){

		if(Auth::user()->profil_id == 3) {

			// $this->validate($request, [
				// 'current_password' => 'required|string',
				// 'new_password' => 'required|confirmed|min:6|string'
			// ]);

			$rules = [
                'current_password' => 'required|string',
				'new_password' => 'required|confirmed|min:6|string',
            ];

            $customMessages = [
                'current_password.required'=>"Le mot de passe est obligatoire",
				'current_password.min' =>"Veuillez saisir un mot de passe de plus de 5 caratères",
				'new_password.required' => "Le nouveau mot de passe est obligatoire",
				'new_password.confirmed' => "La confirmation n'est pas conforme au nouveau mot de passe",
            ];

            $this->validate($request,$rules,$customMessages);

			$auth = Auth::user();

			// Les mots de passe correspondent
			if (!Hash::check($request->get('current_password'), $auth->password))
			{
				return back()->with('info_error', "Le mot de passe actuel n'est pas correct");
			}

			// Mot de passe actuel et nouveau mot de passe identiques
			if (strcmp($request->get('current_password'), $request->new_password) == 0)
			{
				return redirect()->back()->with("info_error", "Le nouveau mot de passe n'est pas le même que votre mot de passe actuel.");
			}

			$user =  User::find($auth->id);

			$user->password =  Hash::make($request->new_password);
			$user->save();

			return back()->with('info_succes', "Le mot de passe a été changé avec succès");

		}else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
	}

	//Message
	public function Message(){

		if(Auth::user()->profil_id == 3) {

			return view('pointvente.message');

		}else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
	}

	//Recherche de voyage
	public function ReserverTicket(){

		if(Auth::user()->profil_id == 3) {

			$villes = Ville::where(['ville_statut'=>"VALIDE"])->orderby('ville_libelle')->get();

			return view('pointvente.reserverticket',['villes'=>$villes]);

		}else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
	}

	//Résultats de recherche de voyage
    public function ResultatRechercheVoyage(Request $request){
        if(Auth::user()->profil_id == 3) {

	        $request->validate([
	            'v' => ['required', 'string', 'max:255'],
	            'd' => ['required', 'string', 'max:255'],
	            'dt' => ['required', 'string', 'max:255'],
	        ]);

	        $ville_depart = $request->v;
			$ville_destination = $request->d;
			$date_depart = $request->dt;
			$heure_depart = date('Y-m-d H:i:s');

			$whereRaw = ' 1 ';

			if (!empty($ville_depart)) {
			    $whereRaw .= ' AND voyligne.ville_id01 = ?';
			}
			if (!empty($ville_destination)) {
			    $whereRaw .= ' AND voyligne.ville_id02 = ?';
			}
			if (!empty($date_depart)) {
			    $whereRaw .= ' AND voydepart.depart_date_prevue LIKE ?';
			}
			if (!empty($heure_depart)) {
			    //$whereRaw .= ' AND voydepart.depart_heure_prevue >= ?';
			}
            //die($whereRaw);
			$depart_prevus = Depart::join('voyligne', 'voyligne.ligne_id', 'voydepart.ligne_id')
			                       ->join('voycompagnie', 'voycompagnie.compagnie_id', 'voyligne.compagnie_id')
			                       ->join('voygare', 'voygare.compagnie_id', 'voycompagnie.compagnie_id')
			                       ->join('voyvehicule', 'voyvehicule.vehicule_id', 'voydepart.vehicule_id')
			                       ->where('voydepart.depart_capacitevehicule', '>', 0)
			                       ->whereRaw($whereRaw, [$ville_depart, $ville_destination, "%$date_depart%", $heure_depart])
			                       ->orderBy('depart_heure_prevue', 'ASC')
			                       ->orderBy('depart_tarif', 'ASC')
			                       ->paginate(15);

	        //dd($depart_prevus);

	        if(!empty($depart_prevus)){

	            $villes = Ville::where(['ville_statut'=>"VALIDE"])->orderby('ville_libelle')->get();

	            return view('pointvente.resultat')->with(['depart_prevus'=>$depart_prevus,'villes'=>$villes, 'ville_depart_selected'=>$ville_depart, 'ville_destination_selected'=>$ville_destination, 'date_depart_selected'=>$date_depart]);
	        }

	    }else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
    }

	//Information sur la réservation
    public function FaireReservation($depart_id){
        if(Auth::user()->profil_id == 3) {

	        $reservation = Depart::where(['depart_id'=>$depart_id, 'depart_statut'=>'VALIDE'])->first();

			$paramsfrais = DB::table('paramfrais')
								->where('paramfrais_datedebeffet', '<=', $reservation->depart_date_prevue)
								->where('paramfrais_datefineffet', '>=', $reservation->depart_date_prevue)
								->first();

			//dd($paramsfrais);
	        return view('pointvente.reservation', ['reservation'=>$reservation, 'paramsfrais'=>$paramsfrais]);
	    }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");

        }
    }

    // Exporter les tickets de voyage Excel
    public function FactureExportExcel(Request $request){
        if(Auth::user()->profil_id == 3) {

		    $rules = [
                'start_date' => 'required|date',
		        'end_date' => 'required|date|after_or_equal:start_date',
            ];

            $customMessages = [
                'start_date.required'=>"La date de départ est obligatoire",
                'start_date.date'=>"Ce champ est de type de date",
                'end_date.required'=>"La date de fin est obligatoire",
                'end_date.date'=>"Ce champ est de type de date",
                'end_date.after_or_equal'=>"La date de fin doit être supérieur ou égal à la date départ",
            ];

            $this->validate($request,$rules,$customMessages);

            $factures = Facture::select("client_code",'client_nom','client_prenoms', 'client_telephone', 'ligne_designation', 'facture_nbr_ticket', "facture_montant_total", "facture_partpdv", "facture_statut_paiement", "facture_date_paiement")
		                        ->join('voyclient','voyclient.client_id','voyfacture.client_id')
		                        ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
		                        ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
		                        ->where(['voyfacture.user_id'=>Auth::user()->id])
		                        ->whereBetween('facture_date_paiement', [$request->start_date, $request->end_date])
		                        ->orderby('facture_id','DESC')
		                        ->get();

            return Excel::download(new PDVFacturesExport($factures), 'reservations.xlsx');

        }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");

        }
    }

    // Exporter les tickets de voyage PDF
    public function FactureExportPDF(Request $request){

        if(Auth::user()->profil_id == 3) {

		    $rules = [
                'start_date' => 'required|date',
		        'end_date' => 'required|date|after_or_equal:start_date',
            ];

            $customMessages = [
                'start_date.required'=>"La date de départ est obligatoire",
                'start_date.date'=>"Ce champ est de type de date",
                'end_date.required'=>"La date de fin est obligatoire",
                'end_date.date'=>"Ce champ est de type de date",
                'end_date.after_or_equal'=>"La date de fin doit être supérieur ou égal à la date départ",
            ];

            $this->validate($request,$rules,$customMessages);

            $factures = Facture::join('voyclient','voyclient.client_id','voyfacture.client_id')
		                        ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
		                        ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
		                        ->where(['voyfacture.user_id'=>Auth::user()->id])
		                        ->whereBetween('facture_date_paiement', [$request->start_date, $request->end_date])
		                        ->orderby('facture_id','DESC')
		                        ->get();

            $date_depart = $request->start_date;
            $date_fin = $request->end_date;

            //dd($factures);
            $html = View::make('pointvente.factureexport', compact('factures','date_depart','date_fin'))->render();

	        $dompdf = new Dompdf();
	        $dompdf->loadHtml($html);
	        $dompdf->setPaper('A4', 'portrait');
	        $dompdf->render();

	        return $dompdf->stream("reservations.pdf");

        }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");
        }
    }
}
