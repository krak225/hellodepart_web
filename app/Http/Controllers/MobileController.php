<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\User;
use App\Models\Ville;
use App\Models\Compagnie;
use App\Models\Vehicule;
use App\Models\Gare;
use App\Models\Ligne;
use App\Models\Depart;
use App\Models\Facture;
use App\Models\Client;
use App\Models\Commande;
use App\Models\ProduitCommande;
use App\Models\Reservation;
use App\Models\CheckoutSession;
use Stdfn;
use DB;

class MobileController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }


	//
	public function rechercher_departs($ville_depart = null, $ville_destination = null, $date_depart = null){
		
		// die(json_encode(array($ville_depart, $ville_destination, $date_depart)));
        // $user = auth('api')->user();
		// if($user->profil_id == 3) {

			$heure_depart = date('Y-m-d H:i:s');
			
			//charger les données des tables dans les autres modèles
			// $query_builder = Depart::with(['ligne.tarif','compagnie','gare','vehicule','timbre'])->where('voydepart.depart_capacitevehicule', '>', 0);
			
			$query_builder = Depart::join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
									->with(['ligne','compagnie','gare','vehicule'])
									->where('voydepart.depart_capacitevehicule', '>', 0);

            if (!empty($ville_depart)) {
               $query_builder->where('voyligne.ville_id01', '=', $ville_depart);
            }

            if (!empty($ville_destination)) {
                $query_builder->where('voyligne.ville_id02', '=', $ville_destination);
            }

            if (!empty($date_depart)) {
                //$query_builder->whereRaw('voydepart.depart_date_prevue = ?', [$date_depart]);
			}

            if (!empty($heure_depart)) {
                //$query_builder->whereRaw('voydepart.depart_heure_prevue >= ?', [$heure_depart]);
			}

            $depart_prevus = $query_builder->orderBy('depart_heure_prevue', 'ASC')
                            ->orderBy('depart_tarif', 'ASC')
                            ->get();

		    return $depart_prevus;

        // }else{
            // return response()->json(['error' => 'Unauthorized'], 401);
        // }

	}


    public function alert_emploi(Request $request){

        $user = auth('api')->user();
        return response()->json(['success' => 'Successfull', 'user'=>$user], 200);
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            // 'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required',
            'nom' => 'required',
            'prenoms' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['statut'=>0, 'message'=>"Il y a des erreurs dans le formulaire",'errors' => $validation->errors()],400);
        }

        $user = new User();
        $user->profil_id= 3;
        $user->prenoms= $request->prenoms;
        $user->nom= $request->nom;
        $user->email= $request->email;
        $user->password= bcrypt($request->password);

        $user->save();

        //connecter l'utilisateur
        if (!$token = Auth()->attempt(['email' => $request->email, 'password' => $request->password])) {

            return response()->json(['error' => 'Unauthorized'], 401);

        }

        $user = Auth()->user();
        $token = $user->createToken('HELLODEPART')->accessToken;

        return $this->responseWithToken($token, $user);


	}


    public function resend_otp($user_id)
    {
		$user = User::find($user_id);

		//send otp via mail
        $email_data = array(
            'email' => $user->email,
            'nom' => $user->nom,
            'prenoms' => $user->prenoms,
            'otp' => $user->otp,
        );

        Mail::send('emails.email_otp', $email_data, function ($message) use ($email_data){
			$message->to($email_data['email'])
				->subject("Code de connexion")
				->from('noreply@anpe.com', 'ANPE');
        });

	}


    public function update_profile(Request $request)
    {

		// $validation = $request->validate([
			// 'email' => 'required|max:255',
			// 'password' => 'required',
			// 'nom' => 'required',
			// 'prenoms' => 'required',
		// ]);

	    $user = auth('api')->user();
		//$user = User::where(['email'=>$request->email])->first();
		$user->prenoms= $request->prenoms;
		$user->nom= $request->nom;


        $user->exists = true;
		$user->save();

		//connecter l'utilisateur

        //$token = $user->createToken('JOBBOARD')->plainTextToken;
        $token = $user->createToken('JOBBOARD')->accessToken;

        return $this->responseWithToken($token,$user);

	}


    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['message'=>"Identifiant requis",'error' => $validation->errors()],400);
        }

        if (!$token = Auth()->attempt(['email' => $request->email, 'password' => $request->password])) {

            return response()->json(['error' => 'Login ou ot de passe erroné'], 401);

        }

        $user = auth()->user();
        //$token = $user->createToken('HELLODEPART')->plainTextToken;
        $token = $user->createToken('HELLODEPART')->accessToken;


        return $this->responseWithToken($token, $user);
    }

    public function unauthorize()
    {
        return response()->json(['error'=>"Unauthorize"],401);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json(auth()->user());
    }

    protected function responseWithToken($token, $user)
    {
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'Bearer',
            'user'=>$user,
        ]);
    }


    public function compagnies(Request $request)
    {
        $factures = Facture::get()->sortByDesc('commande_id');

		return $factures;
	}


    public function payerticket(Request $request)
    {
		$user_id = auth('api')->user()->id;
		$depart_id = $request->depart_id;
		$depart = Depart::find($depart_id);
		$tarif_unitaire = $depart->depart_tarif;
		$nbre_ticket = $request->nombre_ticket;
		$nbre_ticket = $request->nbre_ticket;
		$telephone = $request->telephone;
		
		// $nbre_ticket = 1;
		
		if($depart->depart_capacitevehicule >= $nbre_ticket){
			
			if (Client::where('client_telephone', $telephone)->exists()) {
		
				$client = Client::where(['client_telephone'=>$telephone])->first();
			
			}else{
			
				$client = new Client();
							
				$nomComplet = $request->client;				
				$posEspace = strpos($nomComplet, ' ');
				$nom = substr($nomComplet, 0, $posEspace);
				$prenoms = substr($nomComplet, $posEspace + 1);

				$client->depart_id            = $request->depart_id;
				$client->client_nom           = $nom;
				$client->client_prenoms       = $prenoms;
				$client->client_email         = htmlspecialchars($request->email);
				// $client->client_datedepart    = htmlspecialchars($request->date_depart);
				$client->client_telephone     = htmlspecialchars($request->telephone);
				// $client->client_heuredepart   = htmlspecialchars($request->heure_depart);
				// $client->client_prixunitaire  = $depart->depart_tarif;
				// $client->client_nbreplace     = htmlspecialchars($request->nombre_place);
				$client->client_code          = gmdate('Ymd').rand(111111,999999);
				$client->client_ip            = $_SERVER['REMOTE_ADDR'];
				$client->save();

			}

			//Récupérer les paramètrages des frais.
			$paramsfrais = DB::table('paramfrais')
							// ->where('paramfrais_datedebeffet', '<=', $depart->depart_date_prevue)
							// ->where('paramfrais_datefineffet', '>=', $depart->depart_date_prevue)
							->first();
			
			if(!empty($paramsfrais)){
				
				//Renseignement de la table facture
				$facture = new Facture();
				$facture->client_id               	 = $client->client_id;
				$facture->user_id                 	 = $user_id;
				$facture->depart_id               	 = $depart->depart_id;
				$facture->facture_nbr_ticket      	 = $nbre_ticket;
				$facture->facture_origine 		  	 = "PDV";
				$facture->facture_nomprenomspassager = $client->client_nom.' '.$client->client_prenoms;
				$facture->facture_mobilepassager     = $client->client_telephone;
				$facture->facture_numero          	 = gmdate('Ymd').rand(11111,99999);
				$facture->facture_frais 		  	 = ($depart->depart_frais * $nbre_ticket); 
				$facture->facture_timbre_etat 	  	 = ($depart->depart_timbre_etat * $nbre_ticket); 
				$facture->facture_commission 	  	 = ($depart->depart_commission * $nbre_ticket); 
				$facture->facture_montant         	 = ($depart->depart_tarif * $nbre_ticket);
				$facture->facture_montant_total   	 = $facture->facture_frais + $facture->facture_montant;
				$facture->facture_parttelco_in 	  	 = $facture->facture_montant_total * $paramsfrais->paramfrais_tauxtelco_in_wave;
				$facture->facture_statut_paiement 	 = "IMPAYE";
				$facture->facture_total_apayer    	 = $facture->facture_montant_total + $facture->facture_parttelco_in + $facture->facture_timbre_etat;
				$facture->facture_compte_compagnie	 = $facture->facture_montant - $facture->facture_commission;
				$facture->facture_parttelco_out1  	 = $facture->facture_compte_compagnie * $paramsfrais->paramfrais_tauxtelco_out1_wave;
				$facture->facture_partpdv 		  	 = $facture->facture_montant_total * $paramsfrais->paramfrais_tauxpdv;
				$facture->facture_parttelco_out2  	 = $facture->facture_partpdv * $paramsfrais->paramfrais_tauxtelco_out2_wave;
				$facture->facture_total_tiers_out  	 = $facture->facture_compte_compagnie + $facture->facture_parttelco_out1 + $facture->facture_partpdv + $facture->facture_parttelco_out2;
				$facture->facture_compteprincipal    = $facture->facture_total_apayer - $facture->facture_parttelco_in;
				$facture->facture_part_hellodepart 	 = $facture->facture_compteprincipal - $facture->facture_total_tiers_out;
				$facture->facture_date_creation   	 = gmdate('Y-m-d');
				
				$facture->save();
				

				$facture_id = $facture->facture_id;
				
				$facture = Facture::find($facture_id);
				
				//générer un uiid à renvoyer à l'appli mobile
				$transaction_id = Stdfn::guidv4();
				
				//Save checkout data
				$checkout_session 					 				= new CheckoutSession();
				$checkout_session->transaction_id 					= $transaction_id;
				$checkout_session->api_response_id 					= "";
				$checkout_session->checkout_session_nom_operateur 	= 'CINETPAY MOBILE';
				$checkout_session->user_id 							= $user_id;
				$checkout_session->facture_id 						= $facture_id;
				$checkout_session->client_id             			= $client->client_id;//optional
				$checkout_session->depart_id 						= $depart->depart_id;//optional
				$checkout_session->payment_token 					= "from_mobile";
				$checkout_session->payment_url 						= "from_mobile";
				$checkout_session->amount 							= $facture->facture_montant_total;
				$checkout_session->curl_status_code 				= "";
				$checkout_session->payment_status 					= "";
				$checkout_session->checkout_session_date_creation 	= gmdate('Y-m-d H:i:s');
				
				$checkout_session->save();
				
				
				return ['statut'=>1, 'message'=>'FACTURE ENREGISTREE, REDIRECTION VERS PAIEMENT', 'facture'=>$facture, 'checkout_session'=>$checkout_session];
			
			}else{
				
				return ['statut'=>2, 'message'=>'PAS DE FRAIS PARAMETRE'];
				
			}
		
		}else{
			
			return ['status'=>0, 'message'=>'ERREUR LORS DU TRAITEMENT'];
			
		}
		
	}

	//
	public function clients(Request $request)
    {

		$clients = Client::get();

		return $clients;

	}


	//
	public function factures(Request $request)
    {

		$factures = Facture::with(['client','user','depart'])->where(['facture_statut_paiement'=>'PAYE'])->orderBy('facture_id')->get();

		return $factures;

	}

	//
	public function villes()
    {

		$villes = Ville::select('ville_id','ville_libelle','ville_statut')->orderBy('ville_libelle')->get();

		return $villes;

	}

}

