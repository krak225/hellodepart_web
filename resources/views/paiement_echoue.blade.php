@extends('layouts.index')
@section('title')
    Paiement échoué
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
			VEUILLEZ RENSEIGNER CORRECTEMENT LE FORMULAIRE
		</div>
	@endif
	
	<div class="content-wrapper">
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1>Paiement échoué</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
							<li class="breadcrumb-item active">Paiement échoué</li>
						</ol>
					</div>
				</div>
			</div>
		</section>
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-default">
							<div class="card-header">
								<h3 class="card-title">
									<i class="fa fa-plus-circle" style="color:red"></i>
									Echec lors du paiement
								</h3>
							</div>
							<div class="card-body">
								<div class="callout callout-danger">
									<h5>Le paiement a échoué</h5>
									<p><a href="{{ route('pointvente.reserver.ticket')}}">Veuillez réessayer</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection