@extends('layouts.app')
@section('title')
    Consulter ma réservation
@endsection
@section('content')
<style>
    .invalid-feedback{
        color: red;
        font-style: italic;
        font-size: 12px;
    }
</style>
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">Consulter ma réservation</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container pdt80 pdbt80">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7">
            <div class="contact-us">
                <h3>
                    Consulter sa réservation
                </h3>
                <div class="row">
                    <form action="{{ route('consulter.resultat') }}">
                        @if(Session::has('info_warning'))
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="alert alert-warning">
                                    <i class="fa fa-info-circle"></i>
                                    <p class="small-font">
                                        {{Session::get('info_warning')}}
                                    </p>
                                </div>
                            </div>
                        @endif
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input class="form-control @error('n') is-invalid @enderror input-lg" name="n" placeholder="Entrer le numéro d'embarquement" type="text" onkeypress="isInputNumber(event)">
                                </input>
                                @error('n')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Le numéro d'embarquement est obliagatoire</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input class="form-control input-lg" name="password" placeholder="*******" type="password">
                                </input>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Le mot de passe est obliagatoire</strong>
                                    </span>
                                @enderror
                            </div>
                        </div-->
                        <!--div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="alert alert-danger">
                                <i class="fa fa-info-circle">
                                </i>
                                <p class="small-font">
                                    Le champ est à remplir obligatoirement
                                </p>
                            </div>
                        </div-->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button class="btn button-theme btn-lg" href="#" type="submit">
                                Rechercher son ticket
                                <i class="fa fa-long-arrow-right">
                                </i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-5">
            <div class="contact-information">
                <h3>
                    Informations générales
                </h3>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="info-location">
                    <span>
                        <i class="fa fa-map">
                        </i>
                        Riviera Faya, près de l'Église Catholique Saint Paul des Lauriers
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="info-location">
                    <i class="fa fa-envelope">
                    </i>
                    <span>
                        sales@hellodepart.com
                    </span>
                </div>
            </div>
            <!--div class="col-xs-12 col-sm-12 col-md-12">
                <div class="info-location">
                    <span>
                        <i class="fa fa-mobile">
                        </i>
                        (+225) 05 46 044 961
                    </span>
                </div>
            </div-->
        </div>
    </div>
</div>
<script>            
    function isInputNumber(evt){
        
        var ch = String.fromCharCode(evt.which);
        
        if(!(/[0-9]/.test(ch))){
            evt.preventDefault();
        }        
    }
</script>
@endsection