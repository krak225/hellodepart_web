<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use PDF;
use View;
use Dompdf\Dompdf;
use App\Models\Facture;
use App\Models\User;
use App\Models\Compagnie;
use App\Models\Gare;
use App\Models\Tarif;
use App\Models\Depart;
use App\Models\Ville;
use App\Models\Ligne;
use App\Models\Vehicule;
use Illuminate\Support\Facades\DB;
use App\Exports\FacturesExport;
use App\Exports\VoyageFacturesExport;
use Maatwebsite\Excel\Facades\Excel;

class CompagnieController extends Controller
{
    public function __construct(){

        $this->middleware('auth');   
    }

    //Liste des tickets du jours
    public function TicketduJours(){
        
        if(Auth::user()->profil_id == 2) {

            $ticket_payes = Facture::join('voyclient','voyclient.client_id','voyfacture.client_id')
                                ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
                                ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                                ->join('voycompagnie','voycompagnie.compagnie_id','voyligne.compagnie_id')
                                ->where(['voycompagnie.compagnie_id'=>Auth::user()->compagnie_id,'facture_statut_paiement'=>"PAYE"])
                                ->whereRaw('date(facture_date_paiement) = "'.gmdate("Y-m-d").'" ')
                                ->orderby('facture_id','DESC')
                                ->get();

            $date_jours = gmdate('Y-m-d');

            return view('compagnie.ticketsdujours',['ticket_payes'=>$ticket_payes, 'date_jours'=>$date_jours]);
        }else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
    }     

    //Historique des tickets
    public function HistoriqueTickets(){
        
        if(Auth::user()->profil_id == 2) {
            
            $tickets = Facture::join('voyclient','voyclient.client_id','voyfacture.client_id')
                                    ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
                                    ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                                    ->join('voycompagnie','voycompagnie.compagnie_id','voyligne.compagnie_id')
                                    ->where(['voycompagnie.compagnie_id'=>Auth::user()->compagnie_id,'facture_statut_paiement'=>"PAYE"])
                                    ->orderby('facture_id','DESC')
                                    ->get();

            //dd($tickets);
            return view('compagnie.historiquedestickets',['tickets'=>$tickets]);
        }else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        }
    }   

    //Exporter les tickets du jours en version PDF
    public function TicketduJoursExportPDF(Request $request){
        if(Auth::user()->profil_id == 2) {

            $ticketjours = Facture::join('voyclient','voyclient.client_id','voyfacture.client_id')
                            ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
                            ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                            ->join('voycompagnie','voycompagnie.compagnie_id','voyligne.compagnie_id')
                            ->where(['voycompagnie.compagnie_id'=>Auth::user()->compagnie_id,'facture_statut_paiement'=>"PAYE"])
                            ->whereRaw('date(facture_date_paiement) = "'.gmdate("Y-m-d").'" ')
                            ->orderby('facture_id','DESC')
                            ->get();
            
            $compagnie = Compagnie::where(['compagnie_id'=>Auth::user()->compagnie_id])->first();
            $compagnie_logo = 'https://www.hellodepart.com/assets/images/'.$compagnie->compagnie_logo;

            $data = [
                'title' => 'LISTE DES TICKETS PAYES DU',
                'date' => date('m/d/Y'),
                'ticketjours' => $ticketjours,
                'compagnie' => $compagnie,
                'compagnie_logo'=>$compagnie_logo
            ]; 
                
            $pdf = PDF::loadView('compagnie.ticketjoursexportpdf', $data);
         
            return $pdf->download('ticketjourspdf.pdf');

        }else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        } 
    }  

    //Exporter les tickets du jours en version Excel
    public function TicketduJoursExportExcel(Request $request){
        if(Auth::user()->profil_id == 2) {

            return Excel::download(new FacturesExport, 'ticketdujours.xlsx');
           
        }else{

            return redirect()->route('welcome')->with('info_warning',"VOUS N'AVEZ PAS D'ACCÈS À CETTE PAGE");

        } 
    }  

    //Exporter les tickets de voyage Excel
    public function TicketExportExcel(Request $request){
        if(Auth::user()->profil_id == 2) {

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

            $factures = Facture::select("client_code",'client_nom','client_prenoms', 'client_telephone', 'ligne_designation', 'facture_nbr_ticket', "facture_compte_compagnie", "facture_statut_paiement", "facture_date_paiement")
                                ->join('voyclient','voyclient.client_id','voyfacture.client_id')
                                ->join('voydepart','voydepart.depart_id','voyfacture.depart_id')
                                ->join('voyligne','voyligne.ligne_id','voydepart.ligne_id')
                                ->where(['voyligne.compagnie_id'=>Auth::user()->compagnie_id])
                                ->whereBetween('facture_date_paiement', [$request->start_date, $request->end_date])
                                ->orderby('facture_id','DESC')
                                ->get();
              //dd($factures);      
            return Excel::download(new VoyageFacturesExport($factures), 'tickets.xlsx');
           
        }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");

        } 
    } 

    //Exporter les tickets de voyage PDF
    public function TicketExportPDF(Request $request){

        if(Auth::user()->profil_id == 2) {

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
                                ->where(['voyligne.compagnie_id'=>Auth::user()->compagnie_id])
                                ->whereBetween('facture_date_paiement', [$request->start_date, $request->end_date])
                                ->orderby('facture_id','DESC')
                                ->get();
            
            $date_depart = $request->start_date;
            $date_fin = $request->end_date;

            //dd($factures);
            $html = View::make('compagnie.ticketexport', compact('factures','date_depart','date_fin'))->render();

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $dompdf->stream("tickets.pdf");
           
        }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");
        }
    }

    //Liste des gares
    public function ListeGare(){
        if(Auth::user()->profil_id == 2) {

            $gares = Gare::where(['voygare.compagnie_id'=>Auth::user()->compagnie_id])->orderby('gare_id','DESC')->get();
            
            return view('compagnie.listegare',['gares'=>$gares]);
           
        }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");

        } 
    } 

    //Save nouvelle gare
    public function SaveGareCompagnie(Request $request){
        if(Auth::user()->profil_id == 2){
            
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
            $gare->compagnie_id = Auth::user()->compagnie_id; 
            $gare->gare_statut = "VALIDE"; 
            $gare->gare_date_creation = gmdate('Y-m-d H:i:s'); 
            $gare->save(); 
            
            return back()->with('info_succes',"Gare crée avec succès !");
            
        }else{
            return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
        }
    }

    //Liste des véhicules
    public function ListeVehicule(){
        if(Auth::user()->profil_id == 2) {

            $vehicules = Vehicule::where(['voyvehicule.compagnie_id'=>Auth::user()->compagnie_id])
                                    ->orderby('voyvehicule.vehicule_id','DESC')
                                    ->get();
            
            return view('compagnie.listevehicule',['vehicules'=>$vehicules]);
           
        }else{

            return redirect()->route('welcome')->with('info_warning',"Vous n'avez pas d'accès à cette page");

        } 
    } 

    //Save nouveau véhicule
    public function SaveVehiculeCompagnie(Request $request){
        if(Auth::user()->profil_id == 2){
            
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
            $vehicule->compagnie_id = Auth::user()->compagnie_id; 
            $vehicule->vehicule_statut = "VALIDE"; 
            $vehicule->vehicule_date_creation = gmdate('Y-m-d H:i:s'); 
            $vehicule->save(); 
                
            return back()->with('info_succes',"Véhicule crée avec succès !");
            
        }else{
            return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
        }
    }

    //Supprimer véhicule
    public function SupprimerVehiculeCompagnie($vehicule_id){
        if(Auth::user()->profil_id == 2){
            
            $vehicule = Vehicule::find($vehicule_id);
            
            if($vehicule){
                
                $vehicule->delete();
                
                return back()->with('info_succes',"Le véhicule a bien été supprimé avec succès !");
            }
            
        }else{
            return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
        }
    } 

    //Supprimer gare
    public function SupprimerGareCompagnie($gare_id){
        if(Auth::user()->profil_id == 2){
            
            $gare = Gare::find($gare_id);
            
            if($gare){
                
                $gare->delete();
                
                return back()->with('info_succes',"La gare a bien été supprimée avec succès !");
            }
            
        }else{
            return redirect()->route('home')->with('info_warning',"Vous n'avez pas de droit d'accès");
        }
    }
}
