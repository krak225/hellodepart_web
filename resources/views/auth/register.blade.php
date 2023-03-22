@extends('layouts.app')
@section('title')
    Page non trouvée
@endsection
@section('content')
<div class="wrap-notfound pdt80 pdbt80">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="notfound-page">
                    <h1>404</h1>
                    <p>Page non trouvée <br>
                        <span>Désolé, mais la page que vous tentiez d'afficher n'existe pas.</span>
                    </p>
                </div>
                <div class="wrap-form-subscribe">
                    <p>Veuillez contacter notre équipe d'assistance à sales@hellodepart.com</p>
                    <a href="{{ route('welcome') }}" class="btn btn-lg button-theme"><i class="fa fa-reply"></i> De retour à la maison</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection