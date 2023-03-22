@extends('layouts.app')
@section('title')
    Mon ticket d'embarquement
@endsection
@section('content')
<style>
    .invalid-feedback{
        color: red;
        font-style: italic;
        font-size: 12px;
    }
</style>
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">Mon ticket d'embarquement</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="pdt80 pdbt80">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="table-responsive ">
                    <table class="table bg-table">
                        <thead class="text-center">
                            <tr>
                                <th>Numéro</th>
                                <th>Destination</th>
                                <th>Prix unitaire</th>
                                <th>Nombre de ticket</th>
                                <th>Montant Total</th>
                                <th>Imprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>{{ $numero_embarquement->client_code }}</th>
                                <td>{{$destination->ligne_designation }}</td>
                                <td>{{ number_format($numero_embarquement->client_prixunitaire, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $numero_embarquement->client_nbreplace }}</td>
                                <td style="font-weight: bold;">{{ number_format($numero_embarquement->facture_montant, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    <a href="{{ route('imprimer.ticket', $numero_embarquement->facture_id) }}">
                                        <img src="{{ asset('assets/images/imprimer.png') }}" width="120" style="margin-top:-15px">
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection