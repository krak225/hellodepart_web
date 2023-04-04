<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CheckoutSession;
use App\Models\IPN;
use App\Models\Facture;
use App\Models\Depart;
use App\Models\Compagnie;
use Stdfn;
use Exception;
use Mail;
use Auth;


//
class PointVenteCinetPayCallbackController extends Controller
{


    public function __construct()
    {
        //$this->middleware('auth');
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

		return view('paiement_a_confirmer', ['transaction_id'=>$transaction_id, 'montant'=>$montant]);

    }


	//Check transaction status
	public function CheckTransactionStatus($transaction_id, $token)
    {

		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= '174242';

		$status = '';
		$montant = '';

		$params = array(
					"transaction_id"=>$transaction_id,
					"apikey"=>$API_KEY,
					"site_id"=>$SITE_ID
				);


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
		  CURLOPT_POSTFIELDS =>json_encode($params),
		  CURLOPT_HTTPHEADER => array(
			'content-type:application/json'
		  ),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  dd('err: '.$err);
		}
		else{

			$res = json_decode($response);

			$code = $res->code;
			$message = $res->message;
			$montant = $res->data->amount;
			$status = $res->data->status;

			$checkout_session = CheckoutSession::where(['payment_token'=>$token])->first();


			if(!empty($checkout_session)){

				if($status == 'ACCEPTED'){

					return view('pointvente.paiement_reussie', ['status'=>$status, 'montant'=>$montant]);//pay non abouti

					return redirect()->route('home');

				}

			}


		}

		return view('pointvente.paiement_echoue', ['status'=>$status, 'montant'=>$montant]);//pay non abouti

	}


	//Check transaction status
	public function getTransactionStatus($transaction_id, $site_id)
    {

		$API_KEY 			= '1114703932630f91ed741316.24658063';
		// $SITE_ID 			= '174242';
		$SITE_ID 			= $site_id;

		$status = '';
		$montant = '';

		$params = array(
					"transaction_id"=>$transaction_id,
					"apikey"=>$API_KEY,
					"site_id"=>$SITE_ID
				);


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
		  CURLOPT_POSTFIELDS =>json_encode($params),
		  CURLOPT_HTTPHEADER => array(
			'content-type:application/json'
		  ),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  dd('err: '.$err);
		}
		else{

			$result = json_decode($response);

			// $code = $res->code;
			// $message = $res->message;
			// $montant = $res->data->amount;
			// $status = $res->data->status;

			return $result;


		}

	}


	public function pointventenotify_test_partage_revenus(Request $request)
    {

		//TEST POUR VOIR SI LES NOTIFICATIONS ARRIVENT
		// $ipn = new IPN();
		// $ipn->ipn_data = 'Notify Events '.json_encode(['cpm_trans_id'=>$_POST['cpm_trans_id'], 'cpm_site_id'=>$_POST['cpm_site_id'], 'remote_addr'=>$_SERVER['REMOTE_ADDR']]);
		// $ipn->ipn_date = gmdate('Y-m-d H:i:s');
		// $ipn->save();

		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= '174242';

		if(isset($_POST['cpm_trans_id'])) {

			try {
				$id_transaction = $_POST['cpm_trans_id'];
				$checkout_session = CheckoutSession::where(['transaction_id'=>$id_transaction, 'checkout_session_statut_traitement'=>'NON TRAITE'])->first();

				if(!empty($checkout_session)){

					//partage de revenues
					$this->partagerRevenus($checkout_session);

				}

			} catch (Exception $e) {

				echo "Erreur :" . $e->getMessage();

				$output = "Erreur";

				//Save string to log, use FILE_APPEND to append.
				file_put_contents('./log_on_failed'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);

			}

		}

	}


	public function pointventenotify(Request $request)
    {
		
		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$SITE_ID 			= '174242';
		
		//
		if(isset($_POST['cpm_trans_id'])) {

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
				file_put_contents('./log_'.gmdate("Y-m-d H:i:s").'.log', $log, FILE_APPEND);

				//La classe commande correspond à votre colonne qui gère les transactions dans votre base de données

				// Initialisation de CinetPay et Identification du paiement
				$id_transaction = $_POST['cpm_trans_id'];
				// apiKey
				$apikey = $API_KEY;


				// siteId
				$site_id = $_POST['cpm_site_id'];


				// $CinetPay = new CinetPay($site_id, $apikey);
				//On recupère le statut de la transaction dans la base de donnée
				/* $commande->set_transactionId($id_transaction);
					 //Il faut s'assurer que la transaction existe dans notre base de donnée
				 * $commande->getCommandeByTransId();
				 */

				// On verifie que la commande n'a pas encore été traité
				$checkout_session = CheckoutSession::where(['transaction_id'=>$id_transaction, 'checkout_session_statut_traitement'=>'NON TRAITE'])->first();

				if(!empty($checkout_session)){

					// Dans le cas contrait, on verifie l'état de la transaction en cas de tentative de paiement sur CinetPay

					// $CinetPay->getPayStatus($id_transaction, $site_id);
					$transationData = $this->getTransactionStatus($id_transaction, $site_id);

					//Save string to log, use FILE_APPEND to append.
					file_put_contents('./log_transationData'.gmdate("Y-m-d H:i:s").'.log', json_encode($transationData), FILE_APPEND);

					$code = $transationData->code;
					$message  = $transationData->message;
					$status = $transationData->data->status;
					$amount = $transationData->data->amount;
					$currency = $transationData->data->currency;
					$metadata = $transationData->data->metadata;

					$checkout_session->payment_status = $status;

					//Something to write to txt log
					$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.gmdate("Y-m-d H:i:s").PHP_EOL.
						"Code:".$code.PHP_EOL.
						"Message: ".$message.PHP_EOL.
						"Amount: ".$amount.PHP_EOL.
						"currency: ".$currency.PHP_EOL.
						"-------------------------".PHP_EOL;
					//Save string to log, use FILE_APPEND to append.
					file_put_contents('./log_'.gmdate("Y-m-d H:i:s").'.log', $log, FILE_APPEND);

					// On verifie que le montant payé chez CinetPay correspond à notre montant en base de données pour cette transaction
					if ($code == '00' && $amount == $checkout_session->amount) {
						// correct, on delivre le service
						$output = 'Felicitation, votre paiement a été effectué avec succès';
						echo $output;

						//mettre à jour la facture
						$facture = Facture::find($checkout_session->facture_id);
						$facture->facture_statut_paiement = 'PAYE';
						$facture->facture_date_paiement = gmdate("Y-m-d H:i:s");
						$facture->exists = true;
						$facture->update();

						//mettre à jour le nombre de place restante des tickets
						$depart = Depart::find($facture->depart_id);
						$depart->depart_capacitevehicule = $depart->depart_capacitevehicule - $facture->facture_nbr_ticket;
						$depart->depart_nbre_ticket_achete = $depart->depart_nbre_ticket_achete + $facture->facture_nbr_ticket;
						$depart->exists = true;
						$depart->update();


                        //partager les revenus
					    $this->partagerRevenus($checkout_session);


						//Added on 10092022::send notification mail
						// Récupérer les informations sur le compte du point de vente
						$pointvente = User::find($checkout_session->user_id);

						if($pointvente){
							// Email data
							$email_data = array(
								'amount' => $amount,
								'currency' => $currency,
								'transaction_id' => $id_transaction,
								'transaction_date' => gmdate("Y-m-d H:i:s"),
								'nom' => $pointvente->nom,
								'prenoms' => $pointvente->prenoms,
								'email' => $pointvente->email,
							);

							//Envoie des paramètres du mail
							Mail::send('emails.recu_paiement', $email_data, function ($message) use ($email_data){
							$message->to($email_data['email'] ,$email_data['nom'] ,$email_data['prenoms'])
								->subject('Reçu de paiement de ticket de voyage')
								->from('sales@hellodepart.com' ,'HELLODEPART');
							});

                            file_put_contents('./log_mail_sent'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
						}


						//
						$checkout_session->checkout_session_statut_traitement = 'TRAITE';
						$checkout_session->checkout_session_commentaire = $output;


						//Save string to log, use FILE_APPEND to append.
						file_put_contents('./log_on_success'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);


					} else {
						// transaction n'est pas valide
						$output = 'Echec, votre paiement a échoué pour cause : ' .$message;
						echo $output;

						$checkout_session->checkout_session_commentaire = $status;

						//Save string to log, use FILE_APPEND to append.
						file_put_contents('./log_on_failed'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);

					}
					// mise à jour des transactions dans la base de donnée
					/*  $commande->update(); */
					$checkout_session->checkout_session_date_traitement = gmdate('Y-m-d H:i:s');
					$checkout_session->save();


				}else{
					$output = 'Transaction innexisatante ou déjà traitée';

					echo $output;

					file_put_contents('./log_transaction_not_found'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
				}

			} catch (Exception $e) {

				echo "Erreur :" . $e->getMessage();

				$output = "Erreur";

				//Save string to log, use FILE_APPEND to append.
				file_put_contents('./log_on_failed'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);

			}

		} else {
			// direct acces on IPN
			echo "cpm_trans_id non fourni";

			$log = "cpm_trans_id non fourni";
			file_put_contents('./log_'.gmdate("Y-m-d H:i:s").'.log', $log, FILE_APPEND);

		}

    }


	public function pointventeretour(Request $request)
    {

		$token = $request->token;
		$transaction_id = $request->transaction_id;

		# REDIRIGER POUR ATTENDRE LA CONFIRMATION DU PAIEMENT, ET L'INVITER À COMPOSER *133# POUR VALIDER LE PAIEMENT';
		$ipn = new IPN();
		$ipn->ipn_data = 'retour Events '. json_encode($request);
		$ipn->ipn_date = gmdate('Y-m-d H:i:s');
		$ipn->save();

		return $this->CheckTransactionStatus($transaction_id, $token);

		// return redirect()->route('PointVentePaiementAConfirmer');

    }


	public function pointvente_paiement_reussie(Request $request)
    {
		return view('pointvente.paiement_reussie');//pay non abouti

    }


	public function pointvente_paiement_echoue(Request $request)
    {

		return view('pointvente.paiement_echoue');//pay non abouti

    }


	public function partagerRevenus($checkoutsession)
    {

		//$output = json_encode($checkoutsession);
		//file_put_contents('./start_partagerRevenus'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);


		//Obtenir un code d'accès
		$ACCESS_TOKEN 		= $this->getAccessToken();

		//pour plus de sécurité on enregistrera les contacts des partenaires dans nos contacts sur cinetpay
		//donc plus besoin de le faire ici

		$facture = Facture::find($checkoutsession->facture_id);

        if(!empty($facture)){

            $depart = Depart::find($facture->depart_id);

            if(!empty($depart)){

                $pdv = User::find($facture->user_id);

                $compagnie = Compagnie::find($depart->compagnie_id);

                if(!empty($pdv)){

                    if(!empty($compagnie)){
                        //envoyer l'argent à chaque acteur
                        //le point de vente
                        $phone_pdv = $pdv->telephone;
                        $salaire_pdv = ['amount'=>$facture->facture_partpdv, 'phone'=>$phone_pdv, 'prefix'=>'225', 'notify_url'=>'https://cinetpay.com'];

                        $this->sendMoney($ACCESS_TOKEN, $salaire_pdv);

                        //la Compagnie
                        $phone_compagnie = $compagnie->compagnie_mobile;
                        $salaire_compagnie = ['amount'=>$facture->facture_compte_compagnie, 'phone'=>$phone_compagnie, 'prefix'=>'225', 'notify_url'=>'https://cinetpay.com'];

                        $this->sendMoney($ACCESS_TOKEN, $salaire_compagnie);

                        $output = json_encode([$salaire_pdv, $salaire_compagnie]);
                        echo $output;
                        file_put_contents('./succes_partagerRevenus'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);

                    }else{
                        $output = "compagnie ".$depart->compagnie_id." introuvable";
                        echo $output;
                        file_put_contents('./erreur_partagerRevenus_compagnie'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
                    }

                }else{
                    $output = "pdv ".$facture->user_id." introuvable";
                    echo $output;
                    file_put_contents('./erreur_partagerRevenus_pdv'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
                }

            }else{
                $output = "depart ".$checkoutsession->depart_id." introuvable";
                echo $output;
                file_put_contents('./erreur_partagerRevenus_depart'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
            }

        }else{
            $output = "facture ".$checkoutsession->facture_id." introuvable";
            echo $output;
            file_put_contents('./erreur_partagerRevenus'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);
        }

    }

	//Get token to continue
	public function getAccessToken()
    {

		$API_KEY 			= '1114703932630f91ed741316.24658063';
		$PASSWORD 			= 'Bvr!d@2017';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://client.cinetpay.com/v1/auth/login',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => "apikey=$API_KEY&password=$PASSWORD",
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded'
		  ),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {

			$reponse_json = json_decode($response);


			if(isset($reponse_json->data)){

				$access_token 	= $reponse_json->data->token;

				//file_put_contents('./get_access_token'.gmdate("Y-m-d H:i:s").'.log', "confidentiel", FILE_APPEND);

				return $access_token;

			}else{

				return  '';

			}

		}


	}


	public function sendMoney($token, $salaire)
    {
		$data = [$salaire];

		//file_put_contents('./salaire_to_send'.gmdate("Y-m-d H:i:s").'.log', json_encode($salaire), FILE_APPEND);

		$transaction_id = Stdfn::guidv4();
		$curl = curl_init();

		$options = array(
		  CURLOPT_URL => "https://client.cinetpay.com/v1/transfer/money/send/contact?token=$token&transaction_id=$transaction_id",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => 'data='.json_encode($data),
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded'
		  ),
		);

		curl_setopt_array($curl, $options);

		$response = curl_exec($curl);

		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {

			$reponse_json = json_decode($response);

			if(isset($reponse_json->data)){

				//envoyer un mail
				$output = $reponse_json;
				file_put_contents('./money_sent'.gmdate("Y-m-d H:i:s").'.log', $output, FILE_APPEND);


			}else{

				return  '';

			}

		}


	}


}
