<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Models\Facture;
use App\Models\Gare;
use App\Models\User;
use App\Models\Depart;
use App\Models\Ligne;
use App\Models\Ville;
use App\Models\Compagnie;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdministrateurController extends Controller
{
  
    public function __construct(){
        $this->middleware('auth');
    }
	
	//Liste des compagnies
	public function ListeCompagnie(){
		if(Auth::user()->profil_id == 1){
			
			$compagnies = User::join('voycompagnie','voycompagnie.compagnie_id','users.compagnie_id')
								->where(['profil_id'=>2])
								->whereRaw('compagnie_statut <> "SUPPRIME"')
								->orderby('voycompagnie.compagnie_id','DESC')
								->get();
			$villes = Ville::where(['ville_statut'=>"VALIDE"])->orderby('ville_libelle','ASC')->get();

			return view('admin.compagnie.liste',['compagnies'=>$compagnies, 'villes'=>$villes]);
			
		}else{
			return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
		}
	}

	//Save nouvelle compagnie
	public function SaveCompagnie(Request $request){
		if(Auth::user()->profil_id == 1){
			
			$rules = [
				'password' => ['required', 'string', 'min:6', 'confirmed'],
				'logo' => 'required|mimes:png,jpg,jpeg',
                'ville_id' => ['required'],
                'email' => ['required', 'string', 'email', 'unique:users'],
                'mobile' => ['required', 'numeric'],
                'adresse_siege' => ['required', 'string'],
                'nom_representant' => ['required', 'string'],
                'designation' => ['required', 'string'],
            ];
            
            $customMessages = [
				'password.min' => "Le mot de passe doit être d'au moins 6 caractères",
				'password.confirmed' => "La confirmation du mot de passe n'est pas conforme au mot de passe saisi",
				'password.required' => "Le mot de passe est obligatoire",
				'logo.mimes' => "L'extension du logo choisi doit être de png, jpg, jpeg",
				'logo.required' => "Le logo est obligatoire",
                'email.required' => "L'adresse email est obligatoire",
                'email.unique' => "L'adresse email saisie est déjà utilisé par un autre compte",
                'email.email' => "L'adresse email n'est pas valide",
                'ville_id.required' => "La ville de siège de la compagnie est obligatoire",
                'mobile.required' => "Le numéro de téléphone mobile est obligatoire",
                'adresse_siege.required' => "L'adresse géographique du siège est obligatoire",
                'nom_representant.required' => "Le nom du réprésentant est obligatoire",
                'designation.required' => "La désignation de la compagnie est obligatoire",
            ];
            
            $this->validate($request,$rules,$customMessages);
			
			$compagnie = new Compagnie();
			
			// Upload Logo
			if($request->hasFile('logo')){

				$CompagnieLogoName = time().'.'.request()->logo->getClientOriginalExtension();
				request()->logo->move(public_path('assets/images/compagnie'), $CompagnieLogoName);

			}
			if($request->logo !=null){
				$compagnie->compagnie_logo = $CompagnieLogoName ?? NULL;
			}
			
			$compagnie->compagnie_designation = htmlspecialchars($request->designation); 
			$compagnie->compagnie_representant = htmlspecialchars($request->nom_representant); 
			$compagnie->compagnie_adresse_siege = htmlspecialchars($request->adresse_siege); 
			$compagnie->compagnie_mobile = htmlspecialchars($request->mobile); 
			$compagnie->compagnie_phone_bureau = htmlspecialchars($request->phone_bureau); 
			$compagnie->compagnie_fax = htmlspecialchars($request->fax); 
			$compagnie->compagnie_bp = htmlspecialchars($request->bp); 
			$compagnie->compagnie_email = htmlspecialchars($request->email); 
			$compagnie->compagnie_statut = "VALIDE"; 
			$compagnie->compagnie_date_creation = gmdate('Y-m-d H:i:s'); 
			$compagnie->save(); 
			
			$compagnie_id = $compagnie->compagnie_id;

			// Email data
            $email_data = array(
                'nom' => $request->nom_representant,
                'designation' => $request->designation,
                'email' => $request->email,
                'motdepasse' => $request->password,
            );
            
            //Envoie des paramètres du mail
            Mail::send('emails.compagnie', $email_data, function ($message) use ($email_data){
            $message->to($email_data['email'] ,$email_data['nom'])
                ->subject("Votre inscription à HELLODEPART")
                ->from('koffikf25@gmail.com' ,"HELLODEPART");
            });
			
			$user = new User();
			
			$user->profil_id = 2;
			$user->compagnie_id = $compagnie_id;
			$user->prenoms = htmlspecialchars($request->nom_representant);
			$user->adresse_geo = htmlspecialchars($request->adresse_siege);
			$user->ville_id = $request->ville_id;
			$user->email = htmlspecialchars($request->email); 
			$user->password = Hash::make($request->password);
			$user->created_at = gmdate('Y-m-d H:i:s'); 
			$user->save(); 
			
			return redirect()->route('admin.liste.compagnie')->with('info_succes',"Compte compagnie crée avec succès !");
			
		}else{
			return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
		}
	}

	//Supprimer une compagnie
	public function SupprimerCompagnie($compagnie_id){
		if(Auth::user()->profil_id == 1){
			
			$compagnie = Compagnie::find($compagnie_id);

			if($compagnie){

				$compagnie->compagnie_statut = "SUPPRIME";
				$compagnie->exists = true;
				$compagnie->update();

				return back()->with('info_succes',"Compagnie supprimée avec succès");
			}
			
		}else{
			return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
		}
	}

	//Détails de la compagnie
	public function DetailsCompagnie($compagnie_id){
		if(Auth::user()->profil_id == 1){
			
			$compagnie = Compagnie::find($compagnie_id);

			if($compagnie){

				$departs = Depart::join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                            ->join('voyvehicule','voyvehicule.vehicule_id','voydepart.vehicule_id')
                            ->join('voygare','voygare.gare_id','voydepart.gare_id')
                            ->where(['voyligne.compagnie_id'=>$compagnie->compagnie_id])
                            ->orderby('voydepart.depart_id','ASC')
                            ->get();

                $lignes = Ligne::where(['voyligne.compagnie_id'=>$compagnie->compagnie_id])
                            ->orderby('voyligne.ligne_designation','ASC')
                            ->get();

				$gares = Gare::join('voycompagnie','voycompagnie.compagnie_id','voygare.compagnie_id')
							->where(['voygare.compagnie_id'=>$compagnie->compagnie_id])
							->orderby('voygare.gare_id','DESC')
							->get();

				$vehicules = Vehicule::join('voycompagnie','voycompagnie.compagnie_id','voyvehicule.compagnie_id')
									->where(['voyvehicule.compagnie_id'=>$compagnie->compagnie_id])
									->orderby('voyvehicule.vehicule_id','DESC')
									->get();
				$villes = Ville::orderby('ville_libelle','ASC')->get();				
				
				return view('admin.compagnie.details',['compagnie'=>$compagnie, 'gares'=>$gares, 'vehicules'=>$vehicules, 'departs'=>$departs, 'lignes'=>$lignes, 'villes'=>$villes]);
			}
			
		}else{
			return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
		}
	}
	
	//Save nouvelle gare
	public function SaveGare(Request $request, $compagnie_id){
		if(Auth::user()->profil_id == 1){

			$compagnie = Compagnie::find($compagnie_id);

			if($compagnie){

				$rules = [
	                'email' => ['required', 'string', 'email', 'unique:voygare'],
	                'mobile' => ['required', 'numeric'],
	                'adresse_siege' => ['required', 'string'],
	                'nom_responsable' => ['required', 'string'],
	                'designation' => ['required', 'string'],
	            ];
	            
	            $customMessages = [
					'email.required' => "L'adresse email est obligatoire",
	                'email.unique' => "L'adresse email saisie est déjà utilisé par un autre compte",
	                'email.email' => "L'adresse email n'est pas valide",
	                'mobile.required' => "Le numéro de téléphone mobile est obligatoire",
	                'adresse_siege.required' => "L'adresse géographique du siège est obligatoire",
	                'nom_responsable.required' => "Le nom du responsable est obligatoire",
	                'designation.required' => "La désignation de la compagnie est obligatoire",
	            ];
            
	            $this->validate($request,$rules,$customMessages);
				
				$gare = new Gare();
				
				$gare->gare_designation = htmlspecialchars($request->designation); 
				$gare->gare_nom_responsable = htmlspecialchars($request->nom_responsable); 
				$gare->gare_adresse_geographique = htmlspecialchars($request->adresse_siege); 
				$gare->gare_numero_mobile = htmlspecialchars($request->mobile); 
				$gare->gare_phone_bureau = htmlspecialchars($request->phone_bureau); 
				$gare->gare_numero_fax = htmlspecialchars($request->fax); 
				$gare->email = htmlspecialchars($request->email); 
				$gare->compagnie_id = $compagnie->compagnie_id; 
				$gare->gare_statut = "VALIDE"; 
				$gare->gare_date_creation = gmdate('Y-m-d H:i:s'); 
				$gare->save(); 
				
				return back()->with('info_succes',"Gare crée avec succès !");

			}
			
		}else{
			return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
		}
	}
	
	//Supprimer gare
	public function SupprimerGare($gare_id){
		if(Auth::user()->profil_id == 1){
			
			$gare = Gare::find($gare_id);
			
			if($gare){
				
				$gare->delete();
				
				return back()->with('info_succes',"La gare a bien été supprimée avec succès !");
			}
			
		}else{
			return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
		}
	}
	
	//Save nouveau véhicule
	public function SaveVehicule(Request $request, $compagnie_id){
		if(Auth::user()->profil_id == 1){
			
			$compagnie = Compagnie::find($compagnie_id);

			if($compagnie){
				$rules = [
					'image' => 'required|mimes:png,jpg,jpeg',
	                'carateristique' => ['required'],
	                'capacite' => ['required'],
	                'modele' => ['required'],
	                'marque' => ['required', 'string'],
	                'immatriculation' => ['required', 'string'],
	                'numero_car' => ['required', 'string'],
	            ];
	            
	            $customMessages = [
	                'carateristique.required' => "La caratéristique du véhicule est obligatoire",
	                'capacite.required' => "La capacité du véhicule est obligatoire",
	                'modele.required' => "Le modèle du véhicule est obligatoire",
	                'marque.required' => "La marque du véhicule est obligatoire",
	                'immatriculation.required' => "Le numéro d'immatriculation du véhicule est obligatoire",
	                'numero_car.required' => "Le numéro du véhicule est obligatoire",
	            ];
	            
	            $this->validate($request,$rules,$customMessages);
				
				$vehicule = new Vehicule();
				
				if($request->hasFile('image')){

					$VehiculeName = time().'.'.request()->image->getClientOriginalExtension();
					request()->image->move(public_path('assets/images/compagnie'), $VehiculeName);

				}
				if($request->image !=null){
					$vehicule->vehicule_image = $VehiculeName ?? NULL;
				}
				
				$vehicule->vehicule_numero = htmlspecialchars($request->numero_car); 
				$vehicule->vehicule_immatriculation = htmlspecialchars($request->immatriculation); 
				$vehicule->vehicule_marque = htmlspecialchars($request->marque); 
				$vehicule->vehicule_modele = htmlspecialchars($request->modele); 
				$vehicule->vehicule_nombre_place = htmlspecialchars($request->capacite); 
				$vehicule->vehicule_carateristique = htmlspecialchars($request->carateristique); 
				$vehicule->compagnie_id = $compagnie->compagnie_id; 
				$vehicule->vehicule_statut = "VALIDE"; 
				$vehicule->vehicule_date_creation = gmdate('Y-m-d H:i:s'); 
				$vehicule->save(); 
				
				return back()->with('info_succes',"Véhicule crée avec succès !");
			}
			
		}else{
			return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
		}
	}

	//Supprimer véhicule
	public function SupprimerVehicule($vehicule_id){
		if(Auth::user()->profil_id == 1){
			
			$vehicule = Vehicule::find($vehicule_id);
			
			if($vehicule){
				
				$vehicule->delete();
				
				return back()->with('info_succes',"Le véhicule a bien été supprimé avec succès !");
			}
			
		}else{
			return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
		}
	}

    //Save nouvelle ligne
    public function SaveLigneCompagnie(Request $request, $compagnie_id){
        
        if(Auth::user()->profil_id == 1){
            
            $compagnie = Compagnie::find($compagnie_id);

			if($compagnie){

	            $rules = [
	                'ville_id02' => ['required'],
	                'ville_id01' => ['required'],
	            ];
	            
	            $customMessages = [
	                'ville_id02.required' => "La ville de destination est obligatoire",
	                'ville_id01.required' => "La ville de départ est obligatoire",
	            ];
	            
	            $this->validate($request,$rules,$customMessages);

	            if($request->ville_id01 <> $request->ville_id02){
	                
	                $ville_id01 = Ville::where(['ville_id'=>$request->ville_id01])->first();
	                $ville_id02 = Ville::where(['ville_id'=>$request->ville_id02])->first();
	                
	                $ville_01 = mb_strtoupper($ville_id01->ville_libelle, 'UTF-8');
	                $ville_02 = mb_strtoupper($ville_id02->ville_libelle, 'UTF-8');

	                $ligne = new Ligne();
	                
	                $ligne->ligne_designation = $ville_01.' - '.$ville_02; 
	                $ligne->ligne_kilometrage = htmlspecialchars($request->kilometrage); 
	                $ligne->ville_id02 = $request->ville_id02; 
	                $ligne->ville_id01 = $request->ville_id01; 
	                $ligne->compagnie_id = $compagnie->compagnie_id; 
	                $ligne->ligne_statut = "VALIDE"; 
	                $ligne->ligne_date_creation = gmdate('Y-m-d H:i:s'); 
	                $ligne->save();

	                return back()->with('info_succes',"Ligne créée avec succès !");

	            }else{

	               return back()->with('info_warning',"Veuillez choisir des villes différentes !"); 

	            }
	        }   
                
            
        }else{
            return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
        }
    } 

    //Save modifier ligne
    public function SaveModifierLigneCompagnie(Request $request, $ligne_id){
        
        if(Auth::user()->profil_id == 1){

            $ligne = Ligne::find($ligne_id);
            if($ligne){
                $rules = [
                    'ville_id02' => ['required'],
                    'ville_id01' => ['required'],
                ];
                
                $customMessages = [
                    'ville_id02.required' => "La ville de destination est obligatoire",
                    'ville_id01.required' => "La ville de départ est obligatoire",
                ];
                
                $this->validate($request,$rules,$customMessages);
                if($request->ville_id01 <> $request->ville_id02){
                    
                    $ville_id01 = Ville::where(['ville_id'=>$request->ville_id01])->first();
                    $ville_id02 = Ville::where(['ville_id'=>$request->ville_id02])->first();
                    
                    $ville_01 = mb_strtoupper($ville_id01->ville_libelle, 'UTF-8');
                    $ville_02 = mb_strtoupper($ville_id02->ville_libelle, 'UTF-8');
                    
                    $ligne->ligne_designation = $ville_01.' - '.$ville_02; 
                    $ligne->ligne_kilometrage = htmlspecialchars($request->kilometrage); 
                    $ligne->ville_id02 = $request->ville_id02; 
                    $ligne->ville_id01 = $request->ville_id01; 
                    $ligne->ligne_statut = "VALIDE"; 
                    $ligne->ligne_date_creation = gmdate('Y-m-d H:i:s'); 
                    $ligne->exists = true;
                    $ligne->update();

                    return back()->with('info_succes',"Ligne créée avec succès !");

                }else{

                   return back()->with('info_warning',"Veuillez choisir des villes différentes !"); 

                } 
            } 
        }else{
            return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
        }
    }  

    //Supprimer une ligne
    public function SupprimerLigneCompagnie($ligne_id){
        if(Auth::user()->profil_id == 1){

            $ligne = Ligne::find($ligne_id);

            if($ligne){

                $ligne->delete();

                return back()->with('info_succes','Ligne supprimée avec succès !');
            }

        }else{
            return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
        }
    }

    //Save tarif
    public function SaveTarifCompagnie(Request $request, $compagnie_id){
        if(Auth::user()->profil_id == 1) {

            $rules = [
                'end_date' => 'required|date|after_or_equal:start_date',
                'start_date' => 'required|date',
                'montant' => ['required'],
                'ligne_id' => ['required'],
            ];
            
            $customMessages = [
                'ligne_id.required' => "La ligne est obligatoire",
                'montant.required' => "Le montant est obligatoire",
                'start_date.required'=>"La date de départ est obligatoire",
                'start_date.date'=>"Ce champ est de type de date",
                'end_date.required'=>"La date de fin est obligatoire",
                'end_date.date'=>"Ce champ est de type de date",
                'end_date.after_or_equal'=>"La date de fin doit être supérieur ou égal à la date départ",
            ];
            
            $this->validate($request,$rules,$customMessages);

            if (Tarif::where('voytarif.ligne_id', $request->ligne_id)->exists()) {

                $tarif = Tarif::where(['voytarif.ligne_id'=>$request->ligne_id])->first();

                $date_new_fin =  date('Y-m-d', strtotime($request->end_date. ' - 1 days'));

                $tarif->tarif_datevaleurfin = $date_new_fin;
                $tarif->exists = true;
                $tarif->update();
                
                dd("Bonjour j'existe", $date_new_fin);
            
            }else{

                dd('bonjour je suis nouveau');
            }
            
        }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");

        } 
    }

    //Supprimer le tarif
    public function SupprimerTarifCompagnie($tarif_id){
        if(Auth::user()->profil_id == 1) {

            $tarif = Tarif::find($tarif_id);

            if($tarif){

                $tarif->delete();

                return back()->with('info_succes',"Tarif supprimé avec succès !");
            }

        }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");

        } 
    }	
}
