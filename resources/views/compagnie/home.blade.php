@extends('layouts.admin')
@section('title')
	Tableau de bord
@endsection
@section('content')
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Bienvenue sur mon tableau de bord</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
              <li class="breadcrumb-item active">Bienvenue sur mon tableau de bord</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des tickets payés du
                  {{ \Carbon\Carbon::parse($date_jours)->format('d-m-Y')}}
                </h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    @if($ticket_payes->count() > 0)
                      <li class="page-item"><a href="{{ route('compagnie.ticket-export.excel') }}" class="btn btn-success float-end mr-2">Exporter Excel</a></li>
                      <li class="page-item"><a href="{{ route('compagnie.ticket-export.pdf') }}" class="btn btn-primary float-end">Exporter PDF</a></li>
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
@endsection