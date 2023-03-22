@extends('layouts.app')

@section('title')
    Paiement réussi
@endsection

@section('content')

	<!-- Popup Style -->  
	<link rel="stylesheet" href="{{ asset('front-end/css/popup.css') }}">
	<!-- Popup JS -->
	<script src="{{ asset('front-end/js/popup.js') }}"></script>
    <style>
        .sdk {
            display: block;
            position: absolute;
            background-position: center;
            text-align: center;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
	
	<!---page Title --->
	<div class="member-header-footer ">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<ul class="breadcrumbs">
						<li><a href="{{ route('welcome') }}">Home</a></li>
						<li class="active">Paiement réussi</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--Page content -->
	
@if(Session::has('message'))
	<div class="alert alert-success">
	  {{Session::get('message')}}
	</div>
@endif

@if(Session::has('warning'))
	<div class="alert alert-warning">
	  {{Session::get('warning')}}
	</div>
@endif

@if (Session::has('errors'))
	<div class="alert alert-danger">
		Veuillez renseigner correctement le formulaire
	</div>
@endif
<div class="wrap-notfound pdt80 pdbt80">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="notfound-page">
					<h1><img src="{{ asset('assets/images/valider.png') }}" width="200"></h1>
	    			<p>Le paiement a réussi</p>
				</div>
				<div class="wrap-form-subscribe">
                    <a href="{{ route('consulter.reservation')}}" class="btn btn-lg button-theme">Voir ma réservation</a>
				</div>

			</div>
		</div>
	</div>
</div> 
@endsection