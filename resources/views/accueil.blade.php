@extends('layouts.app')
@section('title')
Home
@endsection
@section('content')
    <style>
        .home_slides{
            height:100px !important;
        }
    </style>
    <section id="home_slides" class="home_slides">
        <div class="carousel slide" data-ride="carousel" id="home-slider">
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img alt="" src="{{ asset('assets/images/slider-1.jpg') }}">
                    <div class="carousel-caption" style="margin-top:-55px">
                    </div>
                </div>
                <div class="item">
                    <img alt="" src="{{ asset('assets/images/slider.jpg') }}">
                    <div class="carousel-caption" style="margin-top:-55px">
                    </div>
                </div>
                <div class="item">
                    <img alt="" src="{{ asset('assets/images/slider-2.jpg') }}">
                    <div class="carousel-caption" style="margin-top:-55px">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="wrap-form-property" style="margin-top:180px;">
        <div class="container">
            <div class="row wow">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="wrap-search-bar-hero animated fadeInDown visible" data-animation="fadeInDown" data-animation-delay="2000">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="text-center">
                                    Trouvez le départ que vous recherchez
                                </h4>
                            </div>
                            <div class="panel-body">
                                <form action="{{ route('resultat') }}">
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group mt15">
                                            <select class="chosen-select" name="v" data-placeholder="D'où partez-vous ?" id="property-status">
                                                <option value=""></option>
                                                @foreach($villes as $ville)
                                                    <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                                @endforeach
                                            </select>
                                            @error('v')
                                                <p style="color:red">Ville de départ obligatoire !</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group mt15">
                                            <select name="d" class="chosen-select" data-placeholder="Où allez-vous ?" id="property-type">
                                                <option value=""></option>
                                                @foreach($villes as $ville)
                                                    <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                                @endforeach                                 
                                            </select>
                                            @error('d')
                                                <p style="color:red">Ville de destination obligatoire !</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group mt15">
                                            <input class="form-control input-lg" name="dt" min="<?php echo gmdate('Y-m-d'); ?>" type="date" value="{{ old('dt') }}">
                                            @error('dt')
                                                <p style="color:red">Date de départ obligatoire !</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group mt15">
                                            <button type="submit" class="btn button-md button-theme btn-block mt15 button-recherche"/>
                                                <i class="fa fa-search"></i>Rechercher
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <section class="wow fadeInLeft delay-07s" id="pricing">
        <div class="container">
            <div class="row">
                <div class="card-body" style="margin-bottom:35px; margin-top:25px;">
                    <h2 class="text-center">Comment réserver son ticket de voyage avec HelloDepart?</h2>
                    <br>
                    <!--h4 class="text-center">HelloDepart offre à ses clients deux modes de réservation de ticket de voyage:</h4>
                    <div class="col-8">
                        <p><i class="fa fa-check-circle" style="margin-right:5px"></i>Vous pouvez vous rendre dans un point de vente (PdV) Mobile Money muni de votre titre de transport (argent), comme si vous partiez à la gare de votre compagnie</p>
                        <p><i class="fa fa-check-circle" style="margin-right:5px"></i>Ou payer directement votre ticket depuis notre site Web.</p>
                    </div-->
                    <h3 class="text-center" style="margin-bottom:45px;">Réserver mon ticket de voyage depuis un point de vente (PdV) Mobile Money</h3>
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
    <!--div class="wrap-blog-details pdt80 pdbt80">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="panel panel-default m20" style="margin-top:20px;">
                        <div class="panel-body">
                            <div class="sidebar-blog wow">
                                <div class="sidebar-body wow fadeInUp delay-07s">
                                    <div class="listing-item compact">
                                        <a class="listing-img-container" href="javascript::void(0)">
                                            <img alt="" src="{{ asset('assets/images/bg_reserv.jpg') }}" class="img-responsive">
                                        </a>
                                    </div><br>
                                    <div class="listing-item compact">
                                        <a class="listing-img-container" href="javascript::void(0)">
                                            <img alt="" src="{{ asset('assets/images/bg_reserv0.jpg') }}" class="img-responsive">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="blog-post-detail">
                        <h3>Réserver mon ticket de voyage via Internet</h3><br>
                        <p>
                            <strong>
                                Etape 1 : Choisir mon voyage
                            </strong>
                        </p>
                        <p>
                            <ul>
                                <li>Je renseigne les lieux de départ et de destination</li>
                                <li>Je renseigne également la date de départ</li>
                                <li>Ensuite, je clique sur le bouton « Rechercher »</li>
                            </ul>
                        </p>
                        <p>Une fois mon voyage trouvé, je clique sur le bouton « Réserver », pour remplir mon formulaire de réservation de ticket.</p>
                        <p>
                            <strong style="color: #333333;">
                                Etape 2 : Remplir le formulaire de réservation
                            </strong>
                        </p>
                        <p>
                            <ul>
                                <li>Je modifie éventuellement la quantité de tickets ; le montant à payer est automatiquement recalculé</li>
                                <li>Je renseigne mes informations personnelles: Nom, Prénoms, Phone et éventuellement une adresse email.</li>
                                <li>Je clique sur le bouton «Je réserve mon ticket»</li>
                            </ul>
                        </p>
                        <p>Les différents moyens de paiement (Mobile Money &amp; VISA) s’affichent.</p>
                        <p>
                            <strong style="color: #333333;">
                                Etape 3 : Payer ma réservation
                            </strong>
                        </p>
                        <p>
                            <ul>
                                <li>Je sélectionne un des moyens de paiement suivants : VISA, Orange Money, MTN Money, MOOV Money, Wave</li>
                                <li>Je renseigne mon numéro de téléphone ou celui de ma carte bancaire</li>
                                <li>Je clique sur le bouton «Payer». Je reçois un message m’invitant à valider mon opération.</li>
                            </ul>
                        </p>
                        <p>
                            <strong style="color: #333333;">
                                Etape 4 : Recevoir mon numéro d&#39;embarquement
                            </strong>
                        </p>
                        <p>
                            <ul>
                                <li>Je reçois un SMS de confirmation contenant mon numéro d’embarquement; je reçois le même numéro sur mon interface de réservation en ligne</li>
                            </ul>
                        </p><p>
                            <strong style="color: #333333;">
                                Etape 5 : Imprimer mon ticket de voyage
                            </strong>
                        </p>
                        <p>
                            <ul>
                                <li>Je clique sur le lien «Consulter ma réservation»</li>
                                <li>Je saisis le numéro d’embarquement affiché sur mon interface de réservation ou obtenu par SMS.</li>
                                <li>Je clique sur le bouton «Rechercher mon ticket». Les informations relatives à mon ticket de réservation s’affichent</li>
                                <li>Je clique sur le bouton «Imprimer le Ticket».</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div-->
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