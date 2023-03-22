@extends('layouts.app')
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
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">Résultat de recherche</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="pdt80 pdbt80">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <h4 class="property-title text-center wow fadeInDown delay-07s">
                    Accéder à nos meilleurs offres
                </h4>
                <div class="wrap-sidebar-property wow fadeInLeft delay-07s">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>
                                Rechercher un nouveau départ
                            </h4>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('resultat') }}" autocomplete="off">
                                <div class="form-group">
                                    <label>
                                        Ville de départ
                                    </label>
                                    <select name="v" class="form-control chosen-select" data-placeholder="D'où partez-vous ?">
										<option value=""></option>
										@foreach($villes as $ville)
											<option @if($ville_depart_selected == $ville->ville_id) selected @endif value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
										@endforeach
									</select>
									@error('v')
										<p style="color:red">Sélectionnez une ville de départ !</p>
									@enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        Ville de destination
                                    </label>
                                    <select name="d" class="chosen-select" data-placeholder="Où allez-vous ?" id="property-type">
										<option value=""></option>
										@foreach($villes as $ville)
											<option @if($ville_destination_selected == $ville->ville_id) selected @endif value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
										@endforeach
									</select>
									@error('d')
										<p style="color:red">Sélectionnez une ville de destination !</p>
									@enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        Date de départ
                                    </label>
                                    <input class="form-control input-lg" min="<?php echo gmdate('Y-m-d'); ?>" name="dt" value="{{ $date_depart_selected }}" placeholder="Départ le" type="date">
									@error('dt')
										<p style="color:red">Saisissez une date de départ !</p>
									@enderror
								</div>
                                <button class="btn button-md button-theme btn-block button-recherche" type="submit">
                                    Rechercher
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!--div class="wrap-sidebar-property wow fadeInLeft delay-07s">
                    <div class="panel-default">
                        <div class="panel-heading">
                            <h4>
                                Recent
                                <span>
                                    Property
                                </span>
                            </h4>
                        </div>
                        <div class="listing-item compact">
                            <a class="listing-img-container" href="single-property-page-1.html">
                                <div class="listing-badges">
                                    <span class="featured">
                                        Featured
                                    </span>
                                    <span>
                                        For Rent
                                    </span>
                                </div>
                                <div class="listing-img-content">
                                    <span class="listing-compact-title">
                                        Citra Garden Estate
                                        <i>
                                            $1300 / monthly
                                        </i>
                                    </span>
                                    <ul class="listing-hidden-content">
                                        <li>
                                            Area
                                            <span>
                                                1450 sq ft
                                            </span>
                                        </li>
                                        <li>
                                            Rooms
                                            <span>
                                                3
                                            </span>
                                        </li>
                                        <li>
                                            Beds
                                            <span>
                                                2
                                            </span>
                                        </li>
                                        <li>
                                            Baths
                                            <span>
                                                2
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <img alt="" src="assets/images/640x450.jpg" class="img-responsive">
                            </a>
                        </div>
                        <div class="listing-item compact">
                            <a class="listing-img-container" href="single-property-page-1.html">
                                <div class="listing-badges">
                                    <span class="featured">
                                        Featured
                                    </span>
                                    <span>
                                        For Rent
                                    </span>
                                </div>
                                <div class="listing-img-content">
                                    <span class="listing-compact-title">
                                        Citra Garden Estate
                                        <i>
                                            $1300 / monthly
                                        </i>
                                    </span>
                                    <ul class="listing-hidden-content">
                                        <li>
                                            Area
                                            <span>
                                                1450 sq ft
                                            </span>
                                        </li>
                                        <li>
                                            Rooms
                                            <span>
                                                3
                                            </span>
                                        </li>
                                        <li>
                                            Beds
                                            <span>
                                                2
                                            </span>
                                        </li>
                                        <li>
                                            Baths
                                            <span>
                                                2
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                                <img alt="" src="assets/images/640x450.jpg" class="img-responsive">
                            </a>
                        </div>
                    </div>
                </div-->
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div role="tabpanel" class="paddt20">
                    <div class="clearfix">
                    </div>
                    <hr class="separator-ads">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab" role="tabpanel">
                            <section>
								@forelse($depart_prevus as $depart_prevu)
									<div class="property-listing-list wow fadeInDown delay-07s">
                                        <a href="{{ route('faire.reservation', [$depart_prevu->depart_id, Stdfn::clean_url($depart_prevu->ligne_designation)]) }}">
											<div class="col-xs-12 col-sm-12 col-md-6 nopadd">
												<span class="ribbon" style="font-size:12px;">
													Disponible
												</span>
												<img class="img-responsive property-image" src="{{ asset('assets/images/compagnie/'.$depart_prevu->vehicule_image) }}" alt="">
												<span class="card-title">
													{{ $depart_prevu->depart_tarif }} FCFA / <span style="font-size:12px">{{ $depart_prevu->ligne_designation }}</span>
												</span>
												<span class="card-price">
													{{ $depart_prevu->compagnie_designation }}
												</span>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 nopadd">
												<div class="content-block">
													<span style="font-size:14px; font-weight:bold;">
														Départ le : {{ \Carbon\Carbon::parse($depart_prevu->depart_date_arrivee)->format('d-m-Y') }}
													</span>
													<span style="font-size:14px; font-weight:bold; float: right;">
														Heure départ : {{ \Carbon\Carbon::parse($depart_prevu->depart_heure_arrivee)->format('H:i') }}
													</span>
													<h4>
														{{ $depart_prevu->gare_designation }}
													</h4>
													<div class="text-left">
                                                        <center>
													       <a href="{{ route('faire.reservation', [$depart_prevu->depart_id, Stdfn::clean_url($depart_prevu->ligne_designation)]) }}" class="btn btn-success button-reservation"><i class="fa fa-shopping-cart"></i> Réserver son ticket</a>
												        </center>
                                                    </div>
												</div>
                                                <center>
                                                    <p class="text-clignote">Plus que {{ $depart_prevu->depart_capacitevehicule }} tickets restant</p>
                                                </center>
												<ul class="list-inline area-info">
													<li class="area" data-placement="top" data-toggle="tooltip" title="Date de départ">
														<span>
															<i class="fa fa-calendar"></i>
														</span>
														<span class="text">
															{{ \Carbon\Carbon::parse($depart_prevu->depart_date_arrivee)->format('d-m-Y') }}
														</span>
													</li>
													<li class="area" data-placement="top" data-toggle="tooltip" title="Heure de départ">
														<span>
															<i class="fa-sharp fa-solid fa-clock"></i>
														</span>
														<span class="text">
															{{ \Carbon\Carbon::parse($depart_prevu->depart_heure_arrivee)->format('H:i') }}
														</span>
													</li>
													<li class="area" data-placement="top" data-toggle="tooltip" title="Kilométrage">
														<span>
															<i class="fa-solid fa-road"></i>
														</span>
														<span class="text">
														{{ $depart_prevu->ligne_kilometrage }} KM
														</span>
													</li>
													<li class="area" data-placement="top" data-toggle="tooltip" title="Car Climatisé">
														<span>
															<i class="fa fa-cloud"></i>
														</span>
														<span class="text">
														{{ $depart_prevu->vehicule_carateristique }}
														</span>
													</li>
												</ul>
											</div>
										</a>
									</div>
								@empty									
									<div class="alert alert-info">
										<i class="fa fa-info-circle">
										</i>
										<p class="small-font">
											Aucun départ ne correspond à l'objet de votre recherche.
										</p>
									</div>
								@endforelse
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection