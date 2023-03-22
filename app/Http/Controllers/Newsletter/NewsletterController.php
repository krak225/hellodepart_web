<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\NewsletterMail;
use App\Models\NewsLetter;
use Mail;

class NewsletterController extends Controller
{
    //Envoie de mail newsletter
	public function newslettersend(Request $request){
		
		$request->validate([
			'newsletter_email'=>['required']
		]);	

		$email = $request->input('newsletter_email');

		// Vérification de la validité du mail
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			
			$newsletter = new NewsLetter();

			$newsletter->newsletter_email = $request->input('newsletter_email');
			$newsletter->newsletter_datecrea = gmdate('Y-m-d H:i:s');
			$newsletter->save();

			$contact_data = [
				'email' => $request->input('newsletter_email'),
				'adresse_ip'=> $_SERVER['REMOTE_ADDR'],
			];
			Mail::to('sales@hellodepart.com')->send(new NewsletterMail($contact_data));
			
			return back()->with('info_succes',"EMAIL ENVOYÉ AVEC SUCCÈS !");
			
		}else{
			
			return back()->with('info_error',"L'adresse e-mail n'est pas valide !");
			
		}
	}
}
