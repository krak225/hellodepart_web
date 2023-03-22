<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    //
	public function client(){
		
		$clients = Client::get();
		
		return view('clients',['clients'=>$clients]);
	}
	
	public function create(Request $request){
		
		$client = new Client();
		
		$client->client_nom = htmlspecialchars($request->nom);
		$client->save();
		
		return back()->with('info_statut',"Client crée avec succès !");
	}
	
	public function listefacture(){
		
		$clients = Client::get();
		
		return view('clients',['clients'=>$clients]);
	}
	
	public function details($client_id){
		
		$client = Client::find($client_id);
		
		return view('details',['client'=>$client]);
	}
	
	public function recaptcha(){
		
		return view('recaptcha');
	}
}
