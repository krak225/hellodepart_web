<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ville;

class InscriptionController extends Controller
{
    //Formulaire d'inscription
    public function Inscription(){

        $villes = Ville::orderby('ville_libelle','ASC')->get();

        return view('inscription',['villes'=>$villes]);
    }
}
