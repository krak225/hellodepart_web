@extends('layouts.app')
@section('title')
Home
@endsection
@section('content')
    <section id="home_slides" class="home_slides">
	    <div class="carousel slide" data-ride="carousel" id="home-slider">
	        <ol class="carousel-indicators">
	            <li class="active" data-slide-to="0" data-target="#home-slider">
	            </li>
	            <li data-slide-to="1" data-target="#home-slider">
	            </li>
	            <li data-slide-to="2" data-target="#home-slider">
	            </li>
	        </ol>
	        <div class="carousel-inner" role="listbox">
	            <div class="item active">
	                <img alt="" src="{{ asset('assets/images/slider-1.jpg') }}">
                    <div class="carousel-caption">
                    </div>
	            </div>
	            <div class="item">
	                <img alt="" src="{{ asset('assets/images/slider.jpg') }}">
                    <div class="carousel-caption">
                    </div>
	            </div>
	            <div class="item">
	                <img alt="" src="{{ asset('assets/images/slider-2.jpg') }}">
                    <div class="carousel-caption">
                    </div>
	            </div>
	        </div>
	    </div>
	</section>
    <div class="clearfix"></div>
	<section class="wow fadeInLeft delay-07s" id="pricing">
		<div class="container">
			<div class="row">
				<div class="card-body" style="margin-bottom:35px; margin-top:25px;">
					<h2 class="text-center">Comment réserver son ticket de voyage avec HelloDepart?</h2>
					<br>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<div class="pricing-table">
							<div class="col-md-4 col-sm-12 col-xs-12 wow fadeInUp delay-04s">
								<div class="plan">
									<div class="plan-header">
										<img src="{{ asset('assets/images/etape_1.jpeg') }}">
									</div>
									<div class="plan-list" style="padding: 64px 0 85px;">
										<div style="margin-top:-40px">
											<h4 style="padding:5px; text-align:center">Etape 1 : Réserver mon ticket de voyage depuis un point de vente Mobile Money</h4>
											<p style="padding:5px;"><i class="fa fa-check-circle" style="margin-right:5px"></i>Je me rends dans un PdV Mobile Money muni de mon titre de transport (argent)</p>
											<p style="padding:5px;"><i class="fa fa-check-circle" style="margin-right:5px"></i>Je communique à l’Agent, mes informations de voyage, à savoir, le jour et l’heure du voyage, les villes de départ et de destination, ainsi que mes informations personnelles (Nom, Prénoms, Phone).</p>
											<p style="padding:5px;"><i class="fa fa-check-circle" style="margin-right:5px"></i>Je paie mon ticket à distance en remettant la somme demandée à l’Agent du PdV</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 col-xs-12 wow fadeInUp delay-06s">
								<div class="plan">
									<div class="plan-header">
										<img src="{{ asset('assets/images/etape_2.png') }}">
									</div>
									<div class="plan-list" style="padding: 184px 0 264px;">
										<div style="margin-top: -150px;">
											<h4 style="padding:5px; text-align:center">Etape 2 : Recevoir mon numéro d'embarquement</h4>
											<p style="padding:5px;"><i class="fa fa-check-circle" style="margin-right:5px"></i>Je reçois un SMS de confirmation de la réservation contenant mon numéro d’embarquement</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 col-xs-12 wow fadeInUp delay-09s">
								<div class="plan">
									<div class="plan-header">
										<img src="{{ asset('assets/images/etape_3.jpeg') }}">
									</div>
									<div class="plan-list">
										<h4 style="padding:5px; text-align:center">Etape 3 : Imprimer mon ticket de voyage</h4>
										<p style="padding:5px;"><i class="fa fa-check-circle" style="margin-right:5px"></i>Je peux éventuellement imprimer mon ticket en me rendant sur le site web www.hellodepart.com. Je clique sur le menu «Consulter ma réservation»</p>
										<p style="padding:5px;"><i class="fa fa-check-circle" style="margin-right:5px"></i>Je clique sur le menu «Consulter ma réservation» et je saisis le numéro d’embarquement remis par l’Agent ou obtenu par SMS.</p>
										<p style="padding:5px;"><i class="fa fa-check-circle" style="margin-right:5px"></i>Je clique sur le bouton «Rechercher mon ticket»; Les informations relatives à mon ticket de réservation s’affichent</p>
										<p style="padding:5px;"><i class="fa fa-check-circle" style="margin-right:5px"></i>Je clique sur le bouton «Imprimer le Ticket».</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <div class="clearfix"></div>
    <div class="bg-default wrap-recent-property pdt40 pdbt80 wow fadeInUp delay-08s">
        <div class="container">
            <div class="row">
                <h3 class="text-center" style="margin-left: 12px;">Comment devenir distributeur agréé HelloDepart?</h3>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <h4>Développez votre business grâce à…</h4>
                    <p><strong>Une source de revenus supplémentaires</strong></p>
                    <p>Enrichissez votre gamme de services et votre base de clients pour générer de nouveaux revenus pour votre entreprise.</p>
                    <br>
                    <p><strong>Une opportunité de partenariat Business to business (B2B)</strong></p>
                    <p>Avec HelloDepart, bénéficiez d’une nouvelle opportunité commerciale, et augmentez davantage votre chiffre d’affaires grâce à nos activités de réservation de tickets à distance.</p>
                    <br>
                    <p><strong>Une Assistance 24/7</strong></p>
                    <p>Recevez l’assistance technique dont vous et vos clients avez besoin pour poursuivre le développement de votre activité et de votre cœur de métier.</p>
                    <br>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="profile-img wow fadeInRight delay-07s">
                        <img class="img-responsive" src="{{ asset('assets/images/distributeur.png') }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
            		<p><strong>Inscrivez-vous et enregistrez dès aujourd'hui votre point de vente</strong></p>
                    <p>HelloDepart propose à ses Points de vente une plate-forme de marketing et de business basé sur un système de billetterie innovant.</p>
                    <br><a href="{{ route('register.distributeur') }}" class="btn btn-success button-reservation" style="margin-bottom: 5px;">Inscrivez-vous ici</a>
            	</div>
            </div>
        </div>
    </div>
    <div class="clearfix">
    </div>
@endsection