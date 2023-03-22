@extends('layouts.index')
@section('title')
Résultat de la recherche
@endsection
@section('content')
<style>
    .text-clignote{
       animation-duration: .8s;
       animation-name: clignoter;
       animation-iteration-count: infinite;
       transition: none;
       margin-bottom: -25px;
       color: green;
       font-weight: bold;
    }
    @keyframes clignoter{
      0%   { opacity:1; }
      40%   {opacity:0; }
      100% { opacity:1; }
    }
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Réserver un ticket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des tickets</li>
                        <li class="breadcrumb-item">Réserver un ticket</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Rechercher un départ</h3>
                </div>
                <form action="{{ route('pointvente.resultat.recherche') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>D'où partez-vous ?</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="v">
                                        <option selected="selected" value="">Choisissez une ville de départ</option>
                                        @foreach($villes as $ville)
                                            <option @if($ville_depart_selected == $ville->ville_id) selected @endif value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                        @endforeach
                                    </select>
                                    @error('v')
                                        <p style="color:red">Ville de départ obligatoire !</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Où allez-vous ?</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="d">
                                        <option selected="selected" value="">Choisissez une ville de destination</option>
                                        @foreach($villes as $ville)
                                            <option @if($ville_destination_selected == $ville->ville_id) selected @endif value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                        @endforeach  
                                    </select>
                                    @error('d')
                                        <p style="color:red">Ville de destination obligatoire !</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de départ</label>
                                    <input class="form-control input-lg" name="dt" min="<?php echo gmdate('Y-m-d'); ?>" type="date" value="{{ $date_depart_selected }}">                                            
                                    @error('dt')
                                        <p style="color:red">Date de départ obligatoire !</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
	<section class="content">
	  <div class="container-fluid">
	    <div class="row">
	      <div class="col-12">
	        <div class="card">
	          <div class="card-header">
	            <h3 class="card-title">Liste des départ du :
	            	{{ \Carbon\Carbon::parse($date_depart_selected)->format('d-m-Y') }}
	            	@php 
	            		$date = new DateTime($date_depart_selected);
	            		setlocale(LC_TIME, 'fr_FR.utf8');
						/*echo strftime('%A %d %B %Y', $date->getTimestamp());*/
	            	@endphp
	            </h3>
	          </div>
	          <div class="card-body">
	            <div class="row mt-4">
            		@forelse($depart_prevus as $depart_prevu)
		              	<div class="col-md-4">
				          	<div class="card mb-4 shadow-sm">
				            	<img src="{{ asset('assets/images/compagnie/'.$depart_prevu->vehicule_image) }}" width="100%" height="225">
				            	<div class="card-body">
				            		<span style="font-size:14px; font-weight:bold;">
										Départ le : {{ \Carbon\Carbon::parse($depart_prevu->depart_date_arrivee)->format('d-m-Y') }}
									</span>
									<span style="font-size:14px; font-weight:bold; float: right;">
										Heure départ : {{ \Carbon\Carbon::parse($depart_prevu->depart_heure_prevue)->format('H:i') }}
									</span>
                                    <p style="margin-top:3px; text-align:center">{{ $depart_prevu->ligne_designation }}</p>
									<p class="text-clignote text-center mt-2 mb-4">Plus que {{ $depart_prevu->depart_capacitevehicule }} tickets restant</p>
									<h5 class="text-center">
                                        {{ $depart_prevu->gare_designation }}
									</h5>
									<hr>
					              	<div class="d-flex justify-content-between align-items-center">
						                <div class="btn-group">
						                	<small class="text-muted" style="font-weight:bold; font-size:16px">{{ number_format($depart_prevu->depart_tarif, 0, ',', ' ') }} FCFA</small>
						                </div>
						                <a href="{{ route('pointvente.reservation', [$depart_prevu->depart_id, Stdfn::clean_url($depart_prevu->ligne_designation)]) }}" class="btn btn-sm btn-primary">Réserver un ticket</a>
					              	</div>
				            	</div>
				          	</div>
				        </div>
	              	@empty	
		              	<div class="col-sm-12">								
							<div class="alert alert-info">
								<center>Aucun départ ne correspond à l'objet de votre recherche.</center>
							</div>
						</div>
					@endforelse
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</section>
</div>
@endsection