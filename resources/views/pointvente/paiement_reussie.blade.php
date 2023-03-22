@extends('layouts.index')

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
						<h1>Paiement réussi</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
							<li class="breadcrumb-item active">Paiement réussi</li>
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
									<i class="fa fa-check-circle" style="color:green"></i>
									Le paiement a réussi
								</h3>
							</div>
							<div class="card-body">
								<div class="callout callout-success">
									<h5>Le paiement a réussi</h5>
									<p>
										Allez dans le menu <strong>"Gestion des tickets"</strong> puis dans le sous-menu <strong>"Liste des tickets"</strong> et ouvez le détails du premier tickets sur la liste des ticket pour communiquer le numéro d'embarquement au client.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection