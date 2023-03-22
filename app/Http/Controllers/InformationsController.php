<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformationsController extends Controller
{
    //Page d'affichage du contenu de nos partenaire
    public function DevenirDistributeur(){

        return view('devenirdistributeur');
    }

    //Page d'affichage du contenu des conseils pour réserver son ticket
    public function CommentReserverserTicket(){

        return view('commentreserver');
    }
}
