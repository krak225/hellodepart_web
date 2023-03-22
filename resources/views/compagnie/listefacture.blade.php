@extends('layouts.admin')
@section('title')
    Liste des factures
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
<h3 class="page-title">LISTE DES FACTURES</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ route('home') }}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('compagnie.liste.facture') }}">Gestion des factures</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des factures
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
                    <th class="text-center">Statut</th>
                </tr>
                </thead>
                <tbody>                
                    @foreach($factures as $facture)
                        <tr>
                            <td>
                                <span><i class="fa fa-plus-circle" style="color:green; font-size: 18px;"></i></span>
                            </td>
                            <td>{{ $facture->client_code }}</td>
                            <td>{{ $facture->facture_numero }}</td>
                            <td>{{ number_format($facture->facture_montant, 0, ',', ' ') }} FCFA</td>
                            <td>{{ $facture->client_nom }} {{ $facture->client_prenoms }}</td>
                            <td>{{ \Carbon\Carbon::parse($facture->facture_date_creation)->format('d-m-Y')}}</td>
                            <td class="text-center">
                                @if($facture->facture_statut_paiement == 'PAYE')
                                    <span class="label label-sm label-success">Ticket Payé</span>
                                @elseif($facture->facture_statut_paiement == 'ENREGISTRER')
                                    <span class="label label-sm label-warning">Paiement en cours</span>
                                @else                                    
                                    <span class="label label-sm label-danger">Ticket au Brouillon</span>
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
@endsection