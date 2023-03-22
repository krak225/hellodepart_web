<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Mail;

class ContactController extends Controller
{
    //Affichage de la page de contact
	public function contact(){
		return view('contact.contact');
	}
	
	public function envoiemail(Request $request){
		
		$request->validate([
			'nom'=>['required'],
			'prenoms'=>['required'],
			'email'=>['required'],
			'message'=>['required'],
		]);	

		$email = $request->input('email');

		// Valider l'email
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			
			$contact_data = [
				'nom' => $request->input('nom'),
				'prenoms' => $request->input('prenoms'),
				'email' => $request->input('email'),
				'message' => $request->input('message'),
				'adresse_ip'=> $_SERVER['REMOTE_ADDR'],
			];
			Mail::to('sales@hellodepart.com')->send(new ContactMail($contact_data));
			
			return back()->with('info_succes',"EMAIL ENVOYÉ AVEC SUCCÈS !");
			
		}else{
			
			return back()->with('info_error',"L'ADRESSE E-MAIL N'EST PAS VALIDE !");
			
		}
			
	}
}
