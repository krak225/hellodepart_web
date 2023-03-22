@extends('layouts.app')
@section('title')
    Se connecter
@endsection
@section('content')
<style>
    .wrap-gallery{
        background: #ccc;
    }

    .wrap-gallery .login-row{
        background: #fff;
        padding: 12px;
    }

    .float-end{
        float: right;
    }

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
                    <li><a href="{{ route('welcome') }}">Home</a></li>
                    <li class="active">Se connecter</li>
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
                    Login connexion
                </h3>
                <div class="row">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="alert alert-danger">
                                <i class="fa fa-info-circle">
                                </i>
                                <p class="small-font">
                                    Tous les champs sont à remplir obligatoirement
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group"> 
                                <input class="form-control input-lg" name="email" placeholder="Votre email" type="email" value="{{ old('email') }}">
                                </input>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>L'adresse email est obliagatoire</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input class="form-control input-lg" name="password" placeholder="*******" type="password">
                                </input>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Le mot de passe est obliagatoire</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button class="btn button-theme btn-lg" href="#" type="submit">
                                Se connecter
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
@endsection