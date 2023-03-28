<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\CheckoutSession;
use App\Models\IPN;
use App\Models\Depart;
use App\Models\Facture;
use App\Models\Client;
use App\Models\ParametrageFrais;
use Illuminate\Support\Facades\Validator;
use Stdfn;

//
class PointVenteCinetPayController extends Controller
{
	
	
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	
	public function guidv4($data = null) {
		
		//personalisée
		$data = (strlen($data) == 16 )? $data : random_bytes(16) ;
		
		// Set version to 0100
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
		// Set bits 6-7 to 10
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

		// Output the 36 character UUID.
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
		
	}
	
	
	
	public function initierPaiementCinetPay(Request $request)
	{

		$depart_id    = $request->depart_id;
		$depart = Depart::where(['depart_id'=>$depart_id])->first();

		$telephone = $request->telephone;
		$nbre_ticket = $request->nombre_place;

		//Validation
		$request->validate([
		  'nom' => 'required',
		  'prenoms' => 'required',
		  'telephone' => 'required|numeric|min:10',
		  'nombre_place' => 'required|numeric',
		]);

		if($depart->depart_capacitevehicule >= $nbre_ticket){
			if (Client::where('client_telephone', $telephone)->exists()) {
		
				$client = Client::where(['client.client_telephone'=>$telephone])->first();
			
			}else{
			
				$client = new Client();

				$client->client_nom           = htmlspecialchars($request->nom);
				$client->depart_id           	= $request->depart_id;
				$client->client_prenoms       = htmlspecialchars($request->prenoms);
				$client->client_email         = htmlspecialchars($request->email);
				$client->client_datedepart    = htmlspecialchars($request->date_depart);
				$client->client_telephone     = htmlspecialchars($request->telephone);
				$client->client_heuredepart   = htmlspecialchars($request->heure_depart);
				$client->client_prixunitaire  = $depart->depart_tarif;
				$client->client_nbreplace     = htmlspecialchars($request->nombre_place);
				$client->client_code          = gmdate('Ymd').rand(111111,999999);
				$client->client_ip            = $_SERVER['REMOTE_ADDR'];
				$client->save();

			}

			//Récupérer les paramètrages des frais.
			$paramsfrais = DB::table('paramfrais')
							->where('paramfrais_datedebeffet', '<=', $request->date_depart)
							->where('paramfrais_datefineffet', '>=', $request->date_depart)
							->first();
			
			$nbr_ticket = $request->nombre_place;
			
			//Renseignement de la table facture
			$facture = new Facture();

			$facture->client_id               	 = $client->client_id;
			$facture->user_id                 	 = Auth::user()->id;
			$facture->depart_id               	 = $depart->depart_id;
			$facture->facture_nbr_ticket      	 = $nbr_ticket;
			$facture->facture_origine 		  		 = "PDV";
			$facture->facture_nomprenomspassager = $client->client_nom.' '.$client->client_prenoms;
			$facture->facture_mobilepassager     = $client->client_telephone;
			$facture->facture_numero          	 = gmdate('Ymd').rand(11111,99999);
			$facture->facture_frais 		  			 = ($depart->depart_frais * $request->nombre_place); 
			$facture->facture_timbre_etat 	  	 = $depart->depart_timbre_etat; 
			$facture->facture_commission 	  		 = ($depart->depart_commission * $request->nombre_place); 
			$facture->facture_montant         	 = ($request->montant * $request->nombre_place) + $depart->depart_timbre_etat;
			$facture->facture_montant_total   	 = $facture->facture_frais + $facture->facture_montant;
			$facture->facture_parttelco_in 	  	 = $facture->facture_montant_total * $paramsfrais->paramfrais_tauxtelco_in_wave;
			$facture->facture_statut_paiement 	 = "IMPAYE";
			$facture->facture_total_apayer    	 = $facture->facture_montant_total + $facture->facture_parttelco_in;
			$facture->facture_compte_compagnie	 = $facture->facture_montant - $facture->facture_commission;
			$facture->facture_parttelco_out1  	 = $facture->facture_compte_compagnie * $paramsfrais->paramfrais_tauxtelco_out1_wave;
			$facture->facture_partpdv 		  		 = $facture->facture_total_apayer * $paramsfrais->paramfrais_tauxpdv;
			$facture->facture_parttelco_out2  	 = $facture->facture_partpdv * $paramsfrais->paramfrais_tauxtelco_out2_wave;
			$facture->facture_total_tiers_out  	 = $facture->facture_compte_compagnie + $facture->facture_parttelco_out1 + $facture->facture_partpdv + $facture->facture_parttelco_out2;
			$facture->facture_part_hellodepart 	 = $facture->facture_montant_total - $facture->facture_total_tiers_out;
			$facture->facture_date_creation   	 = gmdate('Y-m-d');
			$facture->save();

			$facture_id = $facture->facture_id;
			
			$facture = Facture::where(['facture_id'=>$facture_id])->first();

			//APPELER L'API DE CINETPAY
			if(!empty($facture)){
				
				$transaction_id 	= $this->guidv4();
				
				$ENDPOINT 			= 'https://api-checkout.cinetpay.com/v2/payment';
				$API_KEY 			= '1114703932630f91ed741316.24658063';
				$SITE_ID 			= '174242';
				$RETURN_URL			= 'https://hellodepart.com/pointventeretour';
				$NOTIFY_URL			= 'https://hellodepart.com/pointventenotify';
				
				$params = array(
					"transaction_id"=>$transaction_id,
					"amount"=>$facture->facture_montant_total,
					"currency"=>"XOF", //Auth::user()->pays_bases->devise,
					"apikey"=>$API_KEY,
					"site_id"=>$SITE_ID,
					"description"=>'Paiement de la facture N° '.$facture->facture_numero,
					"return_url"=>$RETURN_URL,
					"notify_url"=>$NOTIFY_URL,
					"metadata"=>'reserv_'.$facture_id."_pdv_".Auth::user()->id,
					"customer_id"=>Auth::user()->id,
					"customer_name"=>Auth::user()->nom,
					"customer_surname"=>Auth::user()->prenoms,
					"customer_email"=>Auth::user()->email,
					"customer_address"=>Auth::user()->adresse,
					"customer_city"=>Auth::user()->ville->ville_libelle,
					"channels"=>"ALL",
				);
			
				// print '<pre>';print_r($params);print '</pre>';
				// dd();
				
				$curl = curl_init();
				
				curl_setopt_array($curl, array(
				  CURLOPT_URL => $ENDPOINT,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_SSL_VERIFYHOST => 0,
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'POST',
				  CURLOPT_POSTFIELDS =>json_encode($params),
				  CURLOPT_HTTPHEADER => array(
					'content-type:application/json'
				  ),
				));
				
				
				$response 			= curl_exec($curl);
				$err 			  	= curl_error($curl);
				$curl_status_code 	= curl_getinfo($curl, CURLINFO_HTTP_CODE);
					
				curl_close($curl);
				
				if ($err) {
				  echo "cURL Error #:" . $err;
				} else {
					$reponse_json = json_decode($response);
				}
				
				// dd($reponse_json);
				
				$code = $reponse_json->code;
				$message = $reponse_json->message;
				$description = $reponse_json->description;
				$api_response_id = $reponse_json->api_response_id;
				
				//Si http response code 202 : accepted
				if($code == 201){
					
					$payment_url = $reponse_json->data->payment_url;
					$payment_token = $reponse_json->data->payment_token;
					
					//save data in session 
					session(['transaction_id'=> $transaction_id, 'montant'=>$facture->facture_montant_total]);
					
					//Save checkout data
					$checkout_session 																	= new CheckoutSession();
					$checkout_session->transaction_id 									= $transaction_id;
					$checkout_session->api_response_id 									= $api_response_id;
					$checkout_session->checkout_session_nom_operateur 	= 'CINETPAY';
					$checkout_session->user_id 													= Auth::user()->id;
					$checkout_session->client_id             						= $client->client_id;
					$checkout_session->facture_id 											= $facture_id;
					$checkout_session->depart_id 												= $request->depart_id;
					$checkout_session->payment_token 										= $payment_token;
					$checkout_session->payment_url 											= $payment_url;
					$checkout_session->amount 													= $facture->facture_montant_total;
					$checkout_session->curl_status_code 								= $code;
					$checkout_session->payment_status 									= '';
					$checkout_session->checkout_session_date_creation 	= gmdate('Y-m-d H:i:s');
					
					$checkout_session->save();
					
					
					//redirection vers l'url de paiement
					return redirect($payment_url);
					
					
				}else{
					
					// return back()->with('warning',"ERREUR LORS DE L'INITIAION DU PAIEMENT" . $description);
					
					return back()->with('warning',"ERREUR LORS DE L'INITIAION DU PAIEMENT. " . $description);
					
				}	
				
			}else{
				return back()->with('warning', 'Réservation introuvable');
			}

		}else{

			$nbre_ticket_reste = $depart->depart_capacitevehicule;
			
			return back()->with('warning',"Pour ce départ il reste actuellement ".$nbre_ticket_reste." ticket(s)");
		}
		
  }
	
	
	public function PointVentePaiementAConfirmer(Request $request)
    {
		
		$transaction_id = session('transaction_id');
		
		$montant  = session('montant');
		
		// dd($transaction_id);
		
		//si pas encore approuvé, vérifier sur le serveur
		if(!empty($transaction_id)){
			
			$this->CheckTransactionStatus($transaction_id);
			
		}
		
		return view('pointvente.paiement_a_confirmer', ['transaction_id'=>$transaction_id, 'montant'=>$montant]);
		
    }
	
	
	//Check transaction status
	public function CheckTransactionStatus($transaction_id)
    {
		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= '174242';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-checkout.cinetpay.com/v2/payment/check',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"transaction_id":"$transaction_id", //ENTRER VOTRE TRANSACTION ID
			"site_id": "$SITE_ID", //ENTRER VOTRE SITE ID
			"apikey" : "$API_KEY" //ENTRER VOTRE APIKEY

		}',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo $err;
		  //throw new Exception("Error :" . $err);
		} 
		else{
			$res = json_decode($response,true);
			
			/*{
				"code": "00",
				"message": "SUCCES",
				"data": {
					"amount": "100",
					"currency": "XOF",
					"status": "ACCEPTED",
					"payment_method": "OM",
					"description": "GFGHHG",
					"metadata": null,
					"operator_id": "MP210930.1743.C36452",
					"payment_date": "2021-09-30 17:43:30"
				},
				"api_response_id": "1633023959.8459"
			}*/

			print_r($res);
		} 
	
	}
	
	
	public function getTransactionStatus($transaction_id)
    {
		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= '174242';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-checkout.cinetpay.com/v2/payment/check',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
			"transaction_id":"$transaction_id", //ENTRER VOTRE TRANSACTION ID
			"site_id": "$SITE_ID", //ENTRER VOTRE SITE ID
			"apikey" : "$API_KEY" //ENTRER VOTRE APIKEY

		}',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  echo $err;
		  //throw new Exception("Error :" . $err);
		} 
		else{
			$result = json_decode($response,true);
			
			/*{
				"code": "00",
				"message": "SUCCES",
				"data": {
					"amount": "100",
					"currency": "XOF",
					"status": "ACCEPTED",
					"payment_method": "OM",
					"description": "GFGHHG",
					"metadata": null,
					"operator_id": "MP210930.1743.C36452",
					"payment_date": "2021-09-30 17:43:30"
				},
				"api_response_id": "1633023959.8459"
			}*/

			return $result;
			
		} 
	
	}
	
	
	public function pointventenotify(Request $request)
    {
		
		//TEST POUR VOIR SI LES NOTIFICATIONS ARRIVENT
		$ipn = new IPN();
		$ipn->ipn_data = 'Notify Events ';
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();
		
		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= '174242';
		
		//
		if (isset($_POST['cpm_trans_id'])) {
		
			try {
			
				// require_once __DIR__ . '/../src/new-guichet.php';
				// require_once __DIR__ . '/../commande.php';
				// require_once __DIR__ . '/../marchand.php';

				//Création d'un fichier log pour s'assurer que les éléments sont bien exécuté
				$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				"TransId:".$_POST['cpm_trans_id'].PHP_EOL.
				"SiteId: ".$_POST['cpm_site_id'].PHP_EOL.
				"-------------------------".PHP_EOL;
				//Save string to log, use FILE_APPEND to append.
				file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

				//La classe commande correspond à votre colonne qui gère les transactions dans votre base de données
				$commande = new Commande();
				// Initialisation de CinetPay et Identification du paiement
				$id_transaction = $_POST['cpm_trans_id'];
				// apiKey
				$apikey = $API_KEY;


				// siteId
				$site_id = $_POST['cpm_site_id'];


				$CinetPay = new CinetPay($site_id, $apikey);
				//On recupère le statut de la transaction dans la base de donnée
				/* $commande->set_transactionId($id_transaction);
				//Il faut s'assurer que la transaction existe dans notre base de donnée
				* $commande->getCommandeByTransId();
				*/
				
				$checkout_session = CheckoutSession::where(['transaction_id'=>$id_transaction, 'checkout_session_statut_traitement'=>'NON TRAITE'])->first(); 
				

				// On verifie que la commande n'a pas encore été traité
				$VerifyStatusCmd = "1"; // valeur du statut à recupérer dans votre base de donnée
				if (!empty($checkout_session)) {
					
					// Dans le cas contrait, on verifie l'état de la transaction en cas de tentative de paiement sur CinetPay

					// $CinetPay->getPayStatus($id_transaction, $site_id);
					$transactionStatut = $this->getTransactionStatus($id_transaction);
					
					$code = $transactionStatut->code;
					
					$status = $transactionStatut->data->status;
					$amount = $transactionStatut->data->amount;
					$currency = $transactionStatut->data->currency;
					$message = $transactionStatut->data->message;
					$metadata = $transactionStatut->data->metadata;
					

					$checkout_session->payment_status = $status;	
					$checkout_session->checkout_session_statut_traitement = 'TRAITE';	
						
					//Something to write to txt log
					$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
						"Code:".$code.PHP_EOL.
						"Message: ".$message.PHP_EOL.
						"Amount: ".$amount.PHP_EOL.
						"currency: ".$currency.PHP_EOL.
						"-------------------------".PHP_EOL;
					//Save string to log, use FILE_APPEND to append.
					file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

					// On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
					if ($code == '00' && $amount == $checkout_session->amount) {
						// correct, on delivre le service
						echo 'Felicitation, votre paiement a été effectué avec succès';
						
						$checkout_session->checkout_session_commentaire = 'Transaction correcte, on delivre le service';
						
					} else {
						// transaction n'est pas valide
						echo 'Echec, votre paiement a échoué pour cause : ' .$message;
						
						$checkout_session->checkout_session_commentaire = 'Transaction échoué : ' .$message;
						
					}
					// mise à jour des transactions dans la base de donnée
					/*  $commande->update(); */
					
					$checkout_session->checkout_session_date_traitement = gmdate('Y-m-d H:i:s');	
					$checkout_session->save();	
					
					
				}else{
					die('DEJA TRAITE');
				}			

			} catch (Exception $e) {
				echo "Erreur :" . $e->getMessage();
			}
		} else {
			// direct acces on IPN
			echo "cpm_trans_id non fourni";
		}
		
    }
	
	
	public function pointventeretour(Request $request)
    {
		
		# REDIRIGER POUR ATTENDRE LA CONFIRMATION DU PAIEMENT, ET L'INVITER À COMPOSER *133# POUR VALIDER LE PAIEMENT';
		$ipn = new IPN();
		$ipn->ipn_data = 'retour Events ';
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();
		return redirect()->route('PointVentePaiementAConfirmer');
		
    }
	
	public function MTNError(Request $request)
    {
		dd('MTNError');
    }
	
	
}
