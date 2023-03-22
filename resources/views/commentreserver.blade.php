@extends('layouts.app')
@section('title')
    Comment réserver un ticket
@endsection
@section('content')
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">Comment réserver un ticket</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="wrap-blog-details pdt80 pdbt80">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 ">
                <div class="panel panel-default m20">
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
                <h3 class="blog-title wow fadeInLeft delay-07s">
                    Comment réserver son ticket de voyage
                </h3>
                <div class="post-meta">
                    <p>
                        Les modes de réservation d’un ticket de voyage se multiplient pour vous offrir toujours plus de choix. <strong>HelloDepart</strong> a pensé à vous avec ce guide d'achat pour vous aider à savoir comment réserver un ticket de voyage simplement. Ce guide vous explique étape par étape comment acheter par internet son ticket.
                    </p>
                </div>
                <div class="blog-post-detail">
                    <img alt="" height="675" src="{{ asset('assets/images/reserver-ticket.jpg') }}" width="900" class="img-responsive">
                    <h3>Comment réserver son ticket de voyage par internet ?</h3><br>
                    <p>
                        <strong>
                            Etape 1 : Choisissez votre voyage en 3 clics :
                        </strong>
                    </p>
                    <p>
                        <ul>
                            <li>Renseignez le lieu de départ et de destination</li>
                            <li>Renseignez la dates de départ</li>
                            <li>Cliquez sur <strong>« Rechercher »</strong> pour trouver votre trajet au meilleur prix</li>
                        </ul>
                    </p>
                    <p>Une fois que vous avez trouvé votre trajet de car, il vous suffit de cliquer sur « Réerserver ». Et finissez votre achat.</p>
                    <p>
                        <strong style="color: #333333;">
                            Etape 2 : Payez votre ticket
                        </strong>
                    </p>
                    <p>
                        Nous proposons les moyens de paiement suivants :
                        <ul>
                            <li><span style="font-weight: bold;">Carte bancaire : </span>carte bleue, Visa ou MasterCard</li>
                            <li><span style="font-weight: bold;">Compte Mobile Money :</span>vous payez simplement avec votre Compte Orange Money, MTN Mobile Money ou MOOV Money.</li>
                        </ul>
                    </p>
                    <p>Une fois que vous avez trouvé votre trajet de car, il vous suffit de cliquer sur « Réserver ». Et finissez votre achat.</p>
                    <p>
                        <strong style="color: #333333;">
                            Etape 3 : Vous recevez un Code d'embarquement
                        </strong>
                    </p>
                    <p>
                        <ul>
                            <li>Rendez-vous sur le site puis cliquez sur le menu <strong>« Consulter ma réservation »</strong></li>
                            <li>Renseignez le formulaire</li>
                            <li>Cliquez sur <strong>« Rechercher son ticket »</strong> pour trouver votre trajet réservation</li>
                        </ul>
                    </p>
                </div>
                <div class="share-wrapper">
                    <h3>
                        Suivez nos actualités d'offres de billeterie
                    </h3>
                    <a href="#" target="_blank">
                        <div class="button-share fb-share">
                            <i class="fa-brands fa-facebook">
                            </i>
                            <span>
                                Facebook
                            </span>
                        </div>
                    </a>
                    <a href="#" target="_blank">
                        <div class="button-share tw-share">
                            <i class="fa-brands fa-twitter">
                            </i>
                            <span>
                                Twitter
                            </span>
                        </div>
                    </a>
                    <a href="mailto::sales@hellodepart.com" target="_blank">
                        <div class="button-share google-share">
                            <i class="fa-brands fa-google-plus">
                            </i>
                            <span>
                                Google+
                            </span>
                        </div>
                    </a>
                    <a href="#" target="_blank">
                        <div class="button-share in-share">
                            <i class="fa-brands fa-linkedin">
                            </i>
                            <span>
                                LINKEDIN
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection