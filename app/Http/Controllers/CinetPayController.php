<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\CheckoutSession;
use App\Models\IPN;
use App\Models\Depart;
use App\Models\Facture;
use App\Models\ParametrageFrais;
use App\Models\Client;
use Stdfn;


class CinetPay 
{
  protected $BASE_URL = null; //generer lien de paiement Pour la production

  //Variable obligatoire identifiant
/**
 * An identifier
 * @var string
 */

  public $amount = null ;
  public $apikey = null ;
  public $site_id = null;
  public $currency = 'XOF';
  public $transaction_id = null;
  public $customer_name = null;
  public $customer_surname = null;
  public $description = null;

  //Variable facultative identifiant
  public $channels = 'ALL';
  public $notify_url= null;
  public $return_url= null;

  //toute les variables 
  public $metadata = null;
  public $alternative_currency = null;
  public $customer_email = null;
  public $customer_phone_number = null;
  public $customer_address = null;
  public $customer_city = null;
  public $customer_country = null;
  public $customer_state = null;
  public $customer_zip_code = null; 

  //variables des payments check
  public $token = null;
  public $chk_payment_date = null;
  public $chk_operator_id = null;
  public $chk_payment_method = null;
  public $chk_code = null;
  public $chk_message = null;
  public $chk_api_response_id = null;
  public $chk_description = null;
  public $chk_amount = null;
  public $chk_currency = null;
  public $chk_metadata = null;
  /**
 * CinetPay constructor.
 * @param $site_id
 * @param $apikey
 * @param string $version
 * @param array $params
 */
  public function __construct($site_id, $apikey, $version = 'v2', $params = null)
  {
	$this->BASE_URL = sprintf('https://api-checkout.cinetpay.com/%s/payment',strtolower($version)); 
	$this->apikey = $apikey;
	$this->site_id = $site_id;
  }

  //generer lien de payment
  public function generatePaymentLink($param)
  {
	$this->CheckDataExist($param, "payment");
	//champs obligatoire
	$this->transaction_id = $param['transaction_id'];
	$this->amount = $param['amount'];
	$this->currency = $param['currency'];
	$this->description = $param['description'];
	//champs quasi obligatoire
	$this->customer_name = $param['customer_name'];
	$this->customer_surname = $param['customer_surname'];
	//champs facultatif
	if (!empty($param['notify_url'])) $this->notify_url = $param['notify_url'];
	if (!empty($param['return_url'])) $this->return_url = $param['return_url'];
	if (!empty($param['channels'])) $this->channels = $param['channels'];
	//exception pour le CREDIT_CARD
	if ($this->channels == "CREDIT_CARD"  )
	$this->checkDataExist($param, "paymentCard");

  if (!empty($param['alternative_currency'])) $this->alternative_currency = $param['alternative_currency'];
  if (!empty($param['customer_email']))  $this->customer_email = $param['customer_email'];
  if (!empty($param['customer_phone_number']))  $this->customer_phone_number = $param['customer_phone_number'];
  if (!empty($param['customer_address']))  $this->customer_address = $param['customer_address'];
  if (!empty($param['customer_city']))  $this->customer_city = $param['customer_city'];
  if (!empty($param['customer_country']))  $this->customer_country = $param['customer_country'];
  if (!empty($param['customer_state']))  $this->customer_state = $param['customer_state'];
  if (!empty($param['customer_zip_code']))  $this->customer_zip_code = $param['customer_zip_code'];
  if (!empty($param['metadata']))  $this->metadata = $param['metadata'];
	//soumission des donnees
	$data = $this->getData();
	
	$flux_json = $this->callCinetpayWsMethod($data, $this->BASE_URL);
	if ( $flux_json == false)
	throw new Exception("Un probleme est survenu lors de l'appel du WS !");

	$paymentUrl = json_decode($flux_json,true);

	if(is_array($paymentUrl))
	{
	  if(empty($paymentUrl['data']))
	  {
		$message = 'Une erreur est survenue, Code: ' . $paymentUrl['code'] . ', Message: ' . $paymentUrl['message'] . ', Description: ' . $paymentUrl['description'];

		throw new Exception($message);
	  }
	  
	  
	}
	
	return $paymentUrl;
  }

  //check data
  public function CheckDataExist($param, $action)// a customiser pour la function check status
  {
	if (empty($this->apikey))
	throw new Exception("Erreur: Apikey non defini");
	if (empty($this->site_id))
	throw new Exception("Erreur: Site_id non defini");
	if (empty($param['transaction_id']))
	$this->transaction_id = $this->generateTransId();

	if($action == "payment")
	{
	  if (empty($param['amount']))
	  throw new Exception("Erreur: Amount non defini");
	  if (empty($param['currency']))
	  throw new Exception("Erreur: Currency non defini");
	  if (empty($param['customer_name']))
	  throw new Exception("Erreur: Customer_name non defini");
	  if (empty($param['description']))
	  throw new Exception("Erreur: description non defini");
	  if (empty($param['customer_surname']))
	  throw new Exception("Erreur: Customer_surname non defini");
	  if (empty($param['notify_url']))
	  throw new Exception("Erreur: notify_url non defini");
	  if (empty($param['return_url']))
	  throw new Exception("Erreur: return_url non defini");
	}
	elseif ($action == "paymentCard") 
	{
	  if (empty($param['customer_email']))
	  throw new Exception("Erreur: customer_email non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_phone_number']))
	  throw new Exception("Erreur: custom_phone_number non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_address']))
	  throw new Exception("Erreur: Customer_address non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_city']))
	  throw new Exception("Erreur: customer_city non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_country']))
	  throw new Exception("Erreur: customer_country non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_state']))
	  throw new Exception("Erreur: Customer_address non defini (champs requis pour le paiement par carte)");
	  if (empty($param['customer_zip_code']))
	  throw new Exception("Erreur: customer_zip_code non defini (champs requis pour le paiement par carte)");
	}
	
  }
  
  //send datas
  private function callCinetpayWsMethod($params, $url, $method = 'POST')
  {
	
	  if (function_exists('curl_version')) {
		 try {
			  $curl = curl_init();
			 
			  curl_setopt_array($curl, array(
				  CURLOPT_URL => $url,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 45,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => $method,
				  CURLOPT_POSTFIELDS => json_encode($params),
				  CURLOPT_SSL_VERIFYPEER => 0,
				  CURLOPT_HTTPHEADER => array(
					  "content-type:application/json"
				  ),
			  ));
			  $response = curl_exec($curl);
			  $err = curl_error($curl);
			  curl_close($curl);
			  if ($err) {
				  throw new Exception("Error :" . $err);
			  } else {
				  return $response;
			  }
		  } catch (Exception $e) {
			  throw new Exception($e);
		  }
	  }  else {
		  throw new Exception("Vous devez activer curl ou allow_url_fopen pour utiliser CinetPay");
	  }
  }
  //getData
  public function getData()
  {
	$dataArray = array(
	  "amount"=> $this->amount,
	  "apikey"=> $this->apikey,
	  "site_id"=> $this->site_id,
	  "currency"=> $this->currency,
	  "transaction_id"=> $this->transaction_id,
	  "customer_surname"=> $this->customer_surname,
	  "customer_name"=> $this->customer_name,
	  "description"=> $this->description,
	  "notify_url"=> $this->notify_url,
	  "return_url"=> $this->return_url,
	  "channels"=> $this->channels,
	  "alternative_currency"=> $this->alternative_currency,
	  "customer_email"=> $this->customer_email,
	  "customer_phone_number"=> $this->customer_phone_number,
	  "customer_address"=> $this->customer_address,
	  "customer_city"=> $this->customer_city,
	  "customer_country"=> $this->customer_country,
	  "customer_state"=> $this->customer_state,
	  "customer_zip_code"=> $this->customer_zip_code,
	  "metadata" => $this->metadata,
	);
	return $dataArray;
  }
  //get payStatus
  public function getPayStatus($id_transaction,$site_id)
  {
	$data = (array)$this->getPayStatusArray($id_transaction,$site_id);
	
	$flux_json = $this->callCinetpayWsMethod($data, $this->BASE_URL."/check");

   
	if ( $flux_json == false)
	throw new Exception("Un probleme est survenu lors de l'appel du WS !"); 
	
	$StatusPayment = json_decode($flux_json, true);

	if(is_array($StatusPayment))
	{
	  if(empty($StatusPayment['data']))
	  {
		$message = 'Une erreur est survenue, Code: ' . $StatusPayment['code'] . ', Message: ' . $StatusPayment['message'] . ', Description: ' . $StatusPayment['description'];

		throw new Exception($message);
	  }
	  
	}
	$this->chk_payment_date = $StatusPayment['data']['payment_date'];
	$this->chk_operator_id = $StatusPayment['data']['operator_id'];
	$this->chk_payment_method = $StatusPayment['data']['payment_method'];
	$this->chk_amount = $StatusPayment['data']['amount'];
	$this->chk_currency = $StatusPayment['data']['currency'];
	$this->chk_code = $StatusPayment['code'];
	$this->chk_message = $StatusPayment['message'];
	$this->chk_api_response_id = $StatusPayment['api_response_id'];
	$this->chk_description = $StatusPayment['data']['description'];
	$this->chk_metadata = $StatusPayment['data']['metadata'];
  }
  private function getPayStatusArray($id_transaction,$site_id)
   {
	  return $dataArray = array(
		'apikey' => $this->apikey,
		'site_id' => $site_id,
		'transaction_id' => $id_transaction);

   }
  //generate transId
  /**
   * @return int
   */
  public function generateTransId()
  {
	$timestamp = time();
	$parts = explode(' ', microtime());
	$id = ($timestamp + $parts[0] - strtotime('today 00:00')) * 10;
	$id = "SDK-PHP".sprintf('%06d', $id) . mt_rand(100, 9999);

	return $id;
  }
  /**
   * @param $id
   * @return $this
   */
  public function setTransId($id)
  {
	  $this->transaction_id = $id;
	  return $this;
  }


}



//
class CinetPayController extends Controller
{	
	
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
	
	
	
	public function initPaiementCinetPay(Request $request)
	{
		$depart_id    = $request->depart_id;
		$depart = Depart::where(['depart_id'=>$depart_id])->first();

		$telephone = $request->telephone;

		//Validation
		$request->validate([
		  'nom' => 'required',
		  'prenoms' => 'required',
		  'telephone' => 'required|numeric|min:10',
		  'nombre_place' => 'required|numeric',
		]);

		if (Client::where('client_telephone', $telephone)->exists()) {
		
			$client = Client::where(['client.client_telephone'=>$telephone])->first();
			// dd("Ce client existe");
		}else{
		
			$client = new Client();

			$client->client_nom           = htmlspecialchars($request->nom);
			$client->client_prenoms       = htmlspecialchars($request->prenoms);
			$client->client_email         = htmlspecialchars($request->email);
			$client->client_datedepart    = htmlspecialchars($request->date_depart);
			$client->client_telephone     = htmlspecialchars($request->telephone);
			$client->client_heuredepart   = htmlspecialchars($request->heure_depart);
			$client->client_prixunitaire  = $depart->depart_tarif;
			$client->client_nbreplace     = htmlspecialchars($request->nombre_place);
			$client->client_code          = gmdate('Ymd').rand(11111,99999);
			$client->client_ip            = $_SERVER['REMOTE_ADDR'];
			$client->save();
			// dd("Ce client n'existe pas");

		}

		//Récupérer les paramètrages des frais.
		$paramsfrais = ParametrageFrais::where(['paramfrais_statut' => "VALIDE"])
										->whereRaw('date(paramfrais_datedebeffet) <= "'.$request->date_depart.'" ')
										->orWhereRaw('date(paramfrais_datefineffet) >= "'.$request->date_depart.'" ')
										->first();

		//Renseignement de la table facture
		$facture = new Facture();

		$facture->client_id               = $client->client_id;
		$facture->depart_id               = $depart->depart_id;
		$facture->facture_nbr_ticket      = $client->client_nbreplace;
		$facture->facture_origine 		  = "CLT";
		$facture->facture_parttelco 	  = ($depart->depart_frais * $request->nombre_place) * $paramsfrais->paramfrais_tauxtelco;
		$facture->facture_partpdv 		  = ($depart->depart_frais * $request->nombre_place) * $paramsfrais->paramfrais_tauxpdv;
		$facture->facture_partcjd 		  = ($depart->depart_frais * $request->nombre_place) * $paramsfrais->paramfrais_tauxcjd;
		$facture->facture_numero          = gmdate('Ymd').rand(11111,99999);
		$facture->facture_frais 		  = ($depart->depart_frais * $request->nombre_place); 
		$facture->facture_montant         = ($request->montant * $request->nombre_place) + 100 + ($depart->depart_frais * $request->nombre_place);
		$facture->facture_statut_paiement = "IMPAYE";
		$facture->facture_date_creation   = gmdate('Y-m-d H:i:s');
		$facture->save();
			
		$facture_id = $facture->facture_id;
		
		$facture = Facture::where(['facture_id'=>$facture_id])->first();

		//APPELER L'API DE CINETPAY
		if(!empty($facture)){
			
			$transaction_id 	= $this->guidv4();
			
			$ENDPOINT 			= 'https://api-checkout.cinetpay.com/v2/payment';
			$API_KEY 			= '1114703932630f91ed741316.24658063';
			$SITE_ID 			= '174242';
			$RETURN_URL			= 'https://hellodepart.com/retour';
			$NOTIFY_URL			= 'https://hellodepart.com/notify';
			
			$params = array(
				"transaction_id"=>$transaction_id,
				"amount"=>$facture->facture_montant,
				"currency"=>"XOF",
				"apikey"=>$API_KEY,
				"site_id"=>$SITE_ID,
				"description"=>'Paiement de la réservation N° '.$facture->facture_numero,
				"return_url"=>$RETURN_URL,
				"notify_url"=>$NOTIFY_URL,
				"metadata"=>'reserv_'.$facture->facture_id."_client_".$client->client_id,
				"customer_id"=>$client->client_id,
				"customer_name"=>$client->client_nom,
				"customer_surname"=>$client->client_prenoms,
				"customer_email"=>$client->client_email,
				"customer_phone_number"=>$client->client_telephone,
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
				session(['transaction_id'=> $transaction_id, 'montant'=>$facture->facture_montant]);
				
				//Save checkout data
				$checkout_session 																	= new CheckoutSession();

				$checkout_session->transaction_id 									= $transaction_id;
				$checkout_session->api_response_id 									= $api_response_id;
				$checkout_session->checkout_session_nom_operateur 	= 'CINETPAY';
				$checkout_session->client_id 												= $client->client_id;
				$checkout_session->facture_id 											= $facture->facture_id;
				$checkout_session->payment_token 										= $payment_token;
				$checkout_session->payment_url 											= $payment_url;
				$checkout_session->amount 													= $facture->facture_montant;
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
		
    }
	
	
	public function PaiementAConfirmer(Request $request)
    {
		
		$transaction_id = session('transaction_id');
		
		$montant  = session('montant');
		
		// dd($transaction_id);
		
		//si pas encore approuvé, vérifier sur le serveur
		if(!empty($transaction_id)){
			
			$this->CheckTransactionStatus($transaction_id);
			
		}
		
		return view('paiement_a_confirmer', ['transaction_id'=>$transaction_id, 'montant'=>$montant]);
		
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
	
	
	public function notify(Request $request)
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
				
				$checkout_session = CheckoutSession::where(['transaction_id'=>$id_transaction, 'checkout_session_statut_traitement'=>"NON TRAITE"])->first(); 
				

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
					$checkout_session->checkout_session_statut_traitement = "TRAITE";	
						
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
	
	
	public function retour(Request $request)
    {
		
		# REDIRIGER POUR ATTENDRE LA CONFIRMATION DU PAIEMENT, ET L'INVITER À COMPOSER *133# POUR VALIDER LE PAIEMENT';
		$ipn = new IPN();
		$ipn->ipn_data = 'retour Events ';
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();
		return redirect()->route('PaiementAConfirmer');
		
    }
	
	public function MTNError(Request $request)
    {
		dd('MTNError');
    }
	
	
}
