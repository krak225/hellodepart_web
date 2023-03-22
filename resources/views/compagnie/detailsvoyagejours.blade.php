@extends('layouts.admin')
@section('title')
	Détails du voyage {{ $trajet->trajet_depart }} -- {{ $trajet->trajet_arrive }}
@endsection
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Détails du voyage {{ $trajet->trajet_depart }} -- {{ $trajet->trajet_arrive }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item">Gestion des voyages</li>
            <li class="breadcrumb-item">Voyage du jours</li>
          </ol>

        </div>
      </div>
    </div>
  </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des tickets payés
                </h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    @if($ticket_payes->count() > 0)
                      <li class="page-item"><a href="{{ route('compagnie.voyage-details-export.excel',$voyage->voyage_id) }}" class="btn btn-success float-end mr-2">Exporter Excel</a></li>
                      <li class="page-item"><a href="{{ route('compagnie.voyage-details-export.pdf',$voyage->voyage_id) }}" class="btn btn-primary float-end">Exporter PDF</a></li>
                    @endif
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>N° Embarquement</th>
                      <th>Nom & Prénoms</th>
                      <th>Téléphone</th>
                      <th>Destination</th>
                      <th>Nbre Ticket</th>
                      <th>Montant</th>
                      <th class="text-center">Détails</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($ticket_payes as $ticket)
                      <tr>
                        <td>{{ $ticket->client_code }}</td>
                        <td>{{ $ticket->client_nom }} {{ $ticket->client_prenoms }}</td>
                        <td>{{ $ticket->client_telephone }}</td>
                        <td>{{ $ticket->ligne_designation }}</td>
                        <td class="text-center">{{ $ticket->facture_nbr_ticket }}</td>
                        <td>{{ number_format($ticket->facture_montant, 0, ',', ' ') }} FCFA</td>
                        <td class="text-center">
                          <img src="{{ asset('assets/images/details.png') }}" width="26" style="">
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
    </section>
</div>
@endsection