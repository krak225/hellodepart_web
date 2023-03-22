@extends('layouts.admin')
@section('title')
  Historique des tickets
@endsection
@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Historique des tickets</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
              <li class="breadcrumb-item ">Gestion des tickets</li>
              <li class="breadcrumb-item active">Historique des tickets</li>
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
                <h3 class="card-title">Historique des tickets</h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    @if($tickets->count() > 0)
                      <li class="page-item"><a href="" data-toggle="modal" data-target="#modal-export-excel" class="btn btn-success float-end mr-2">Exporter Excel</a></li>
                      <li class="page-item"><a href="" data-toggle="modal" data-target="#modal-export-pdf" class="btn btn-primary float-end">Exporter PDF</a></li>
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
                    @foreach($tickets as $ticket)
                      <tr>
                        <td>{{ $ticket->client_code }}</td>
                        <td>{{ $ticket->client_nom }} {{ $ticket->client_prenoms }}</td>
                        <td>{{ $ticket->client_telephone }}</td>
                        <td>{{ $ticket->ligne_designation }}</td>
                        <td class="text-center">{{ $ticket->facture_nbr_ticket }}</td>
                        <td>{{ number_format($ticket->facture_compte_compagnie, 0, ',', ' ') }} FCFA</td>
                        <td class="text-center">
                          <img src="{{ asset('assets/images/details.png') }}" width="20" style="">
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
  <div class="modal fade" id="modal-export-excel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Exporter une liste</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('compagnie.tickets-export.excel') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Date Début</label>
            <input type="date" required class="form-control" name="start_date">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Date Fin</label>
            <input type="date" required class="form-control" name="end_date">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-export-pdf">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Exporter une liste</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('compagnie.tickets-export.pdf') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Date Début</label>
            <input type="date" required class="form-control" name="start_date">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Date Fin</label>
            <input type="date" required class="form-control" name="end_date">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection