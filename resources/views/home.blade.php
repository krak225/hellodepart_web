@extends('layouts.admin')
@section('title')
    Tableau de Bord
@endsection
@section('content')
<style>
    .bg-primary{
        height: 35px !important;
        background: orange;
        color: #fff;
        margin-top: -6px;
    }

    .tools a:hover{
      background-color: #000;
      color: #fff;
    }
</style>
<h3 class="page-title">TABLEAU DE BORD</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ route('home') }}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Tableau de bord</a>
        </li>
    </ul>
</div>
@if(Auth::user()->profil_id == 2)
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light blue-soft" href="javascript:;">
        <div class="visual">
            <i class="fa fa-comments"></i>
        </div>
        <div class="details">
            <div class="number">
                 1349
            </div>
            <div class="desc">
                 New Feedbacks
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light red-soft" href="javascript:;">
        <div class="visual">
            <i class="fa fa-trophy"></i>
        </div>
        <div class="details">
            <div class="number">
                 12,5M$
            </div>
            <div class="desc">
                 Total Profit
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light green-soft" href="javascript:;">
        <div class="visual">
            <i class="fa fa-shopping-cart"></i>
        </div>
        <div class="details">
            <div class="number">
                 549
            </div>
            <div class="desc">
                 New Orders
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light purple-soft" href="javascript:;">
        <div class="visual">
            <i class="fa fa-globe"></i>
        </div>
        <div class="details">
            <div class="number">
                 +89%
            </div>
            <div class="desc">
                 Brand Popularity
            </div>
        </div>
        </a>
    </div>
</div>
@endif
@if(Auth::user()->profil_id == 3)
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light blue-soft" href="javascript:;">
        <div class="visual">
            <i class="fa fa-comments"></i>
        </div>
        <div class="details">
            <div class="number">
                 1349
            </div>
            <div class="desc">
                 New Feedbacks
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light red-soft" href="javascript:;">
        <div class="visual">
            <i class="fa fa-trophy"></i>
        </div>
        <div class="details">
            <div class="number">
                 12,5M$
            </div>
            <div class="desc">
                 Total Profit
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light green-soft" href="javascript:;">
        <div class="visual">
            <i class="fa fa-shopping-cart"></i>
        </div>
        <div class="details">
            <div class="number">
                 549
            </div>
            <div class="desc">
                 New Orders
            </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light purple-soft" href="javascript:;">
        <div class="visual">
            <i class="fa fa-globe"></i>
        </div>
        <div class="details">
            <div class="number">
                 +89%
            </div>
            <div class="desc">
                 Brand Popularity
            </div>
        </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-credit-card" style="font-size:22px;"></i>Dernières réservations
                </div>
                <div class="tools">
                    <a href="{{ route('index.listereservations') }}" class="btn bg-primary">Liste des réservations</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Numéro Ticket</th>
                                <th>Numéro Paiement</th>
                                <th>Montant Ticket</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>
                                        <span class="tooltips DetailsReservation" data-container="body" data-placement="right" data-html="true" data-original-title="DÉTAILS DE LA RÉSERVATION" data-url="{{ route('index.details.reservation',$reservation->facture_id) }}" data-details="DÉTAILS DE LA DÉCLARATION : {{ $reservation->facture_numero }}"><i class="fa fa-plus-circle" style="color:green; font-size: 21px;"></i></span>
                                    </td>
                                    <td>{{ $reservation->client_code }}</td>
                                    <td>{{ $reservation->facture_numero }}</td>
                                    <td>{{ number_format($reservation->facture_montant, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $reservation->client_nom }} {{ $reservation->client_prenoms }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->facture_date_creation)->format('d-m-Y')}}</td>
                                    <td>
                                        @if($reservation->facture_statut_paiement == 'PAYE')
                                            <span class="badge badge-success">Payée</span>
                                        @elseif($reservation->facture_statut_paiement == 'BROUILLON')
                                            <span class="badge badge-warning">En cours</span>
                                        @elseif($reservation->facture_statut_paiement == 'IMPAYE')
                                            <span class="badge badge-danger">Impayée</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($reservation->facture_statut_paiement == 'PAYE')
                                            <span class="tooltips DetailsReservation" data-container="body" data-placement="left" data-html="true" data-original-title="DÉTAILS DE LA RÉSERVATION" data-url="{{ route('index.details.reservation',$reservation->facture_id) }}" data-details="DÉTAILS DE LA DÉCLARATION : {{ $reservation->facture_numero }}"><i class="fa fa-plus-circle" style="color:green; font-size: 21px;"></i></span>
                                        @elseif($reservation->facture_statut_paiement == 'BROUILLON')
                                            <span class="tooltips DetailsReservation" data-container="body" data-placement="left" data-html="true" data-original-title="DÉTAILS DE LA RÉSERVATION" data-url="{{ route('index.details.reservation',$reservation->facture_id) }}" data-details="DÉTAILS DE LA DÉCLARATION : {{ $reservation->facture_numero }}"><i class="fa fa-plus-circle" style="color:green; font-size: 21px;"></i></span>                                    
                                            <span class="" data-toggle="modal" data-target="#modal-default" title="ANNULER LA RÉSERVATION"><i class="icon-close" style="color:red; font-size: 18px;"></i></span>
                                        @elseif($reservation->facture_statut_paiement == 'IMPAYE')
                                            <span class="tooltips DetailsReservation" data-container="body" data-placement="left" data-html="true" data-original-title="DÉTAILS DE LA RÉSERVATION" data-url="{{ route('index.details.reservation',$reservation->facture_id) }}" data-details="DÉTAILS DE LA DÉCLARATION : {{ $reservation->facture_numero }}"><i class="fa fa-plus-circle" style="color:green; font-size: 21px;"></i></span>
                                            <span class="" data-toggle="modal" data-target="#modal-default" title="ANNULER LA RÉSERVATION"><i class="icon-close" style="color:red; font-size: 18px;"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog">
</div>
@endif
@endsection
