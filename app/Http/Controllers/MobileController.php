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
use Stdfn;

class MobileController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }


	//
	public function rechercher_departs(Request $request){

        // $user = auth('api')->user();
		// if($user->profil_id == 3) {

	        $ville_depart = $request->v;
			$ville_destination = $request->d;
			$date_depart = $request->dt;
			$heure_depart = date('Y-m-d H:i:s');
			
			//charger les données des tables dans les autres modèles
			$query_builder = Depart::with(['ligne.tarif','compagnie','gare','vehicule','timbre'])->where('voydepart.depart_capacitevehicule', '>', 0);
			
			$query_builder = Depart::with(['ligne','compagnie','gare','vehicule'])->where('voydepart.depart_capacitevehicule', '>', 0);

            if (!empty($ville_depart)) {

               // $query_builder->whereHas('ligne', function ($query) use ($ville_depart) {
                 //                   $query->where('voyligne.ville_id01', '=', $ville_depart);
                    //            });
            }

            if (!empty($ville_depart)) {

                //$query_builder->whereHas('ligne', function ($query) use ($ville_destination) {
                                 //   $query->where('voyligne.ville_id02', '=', $ville_destination);
                                //});
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
            'user'=>$user,
            'id'=>$user->id."",
            'firstname'=>$user->prenoms,
            'lastname'=>$user->name,
            'email'=>$user->email,
            'adresse'=>$user->adresse,
            'token_type'=>'Bearer'
        ]);
    }


    public function compagnies(Request $request)
    {
        $factures = Facture::get()->sortByDesc('commande_id');

		return $factures;
	}


    public function payerticket(Request $request)
    {
		$user_id = 1;//auth('api')->user()->id;
		$depart_id = $request->depart_id;

		$facture = new Facture();
		$facture->user_id = $user_id;
		$facture->depart_id = $depart_id;
		$facture->facture_nomprenomspassager = $request->passager;
		$facture->facture_nbr_ticket = $request->nombre_ticket;
		$facture->facture_montant = 1000 * $request->nombre_ticket;
		$facture->facture_partpdv = 100 ;
		$facture->facture_montant_total = 1000 * $request->nombre_ticket + $facture->facture_partpdv;
		$facture->facture_date_creation = gmdate('Y-m-d H:i:s');
		$facture->facture_statut_paiement = 'BROUILLON';
		$facture->save();
		
		return ['status'=>1, 'message'=>'PAIEMENT OK', 'facture'=>$facture];

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

		$factures = Facture::with(['client','user','depart'])->orderBy('facture_id')->get();

		return $factures;

	}

}

