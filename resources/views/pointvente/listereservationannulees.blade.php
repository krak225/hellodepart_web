@extends('layouts.index')
@section('title')
    Liste des réservations annulées
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
<h3 class="page-title">LISTE DES RÉSERVATIONS ANNULÉES</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ route('home') }}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('index.listereservations') }}">Gestion des réservations</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="javascript::void(0)">Liste des réservations annulées</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des réservations annulées
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_6">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Numéro Ticket</th>
                    <th>Numéro Paiement</th>
                    <th>Montant Ticket</th>
                    <th>Client</th>
                    <th>Date</th>
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
                            <td class="text-center">
                                <span class="tooltips DetailsReservation" data-container="body" data-placement="left" data-html="true" data-original-title="DÉTAILS DE LA RÉSERVATION" data-url="{{ route('index.details.reservation',$reservation->facture_id) }}" data-details="DÉTAILS DE LA DÉCLARATION : {{ $reservation->facture_numero }}"><i class="fa fa-plus-circle" style="color:green; font-size: 21px;"></i></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="dialog">
</div>
@endsection