@extends('layouts.index')
@section('title')
    Liste des tickets
@endsection
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Liste des tickets</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item">Gestion des tickets</li>
            <li class="breadcrumb-item">Liste des tickets</li>
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
              <h3 class="card-title">Liste des tickets</h3>
              <div class="card-tools float-end">
                <ul class="pagination pagination-sm float-right">
                  @if($factures->count() > 0)
                    <li class="page-item"><a href="" data-toggle="modal" data-target="#modal-export-excel" class="btn btn-success btn-xs float-end mr-2">Exporter Excel</a></li>
                    <li class="page-item"><a href="" data-toggle="modal" data-target="#modal-export-pdf" class="btn btn-primary btn-xs float-end">Exporter PDF</a></li>
                  @endif
                </ul>
              </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                          <th>Numéro Paiement</th>
                          <th>Client</th>
                          <th>Date</th>
                          <th>Montant</th>
                          <th>Gains</th>
                          <th class="text-center">Statut</th>
                          <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($factures as $facture)
                        <tr>
                          <td>{{ $facture->facture_numero }}</td>
                          <td>{{ $facture->client_nom }} {{ $facture->client_prenoms }}</td>                                    
                          <td>{{ \Carbon\Carbon::parse($facture->facture_date_paiement)->format('d-m-Y')}}</td> 
                          <td>{{ number_format($facture->facture_total_apayer, 0, ',', ' ') }} FCFA</td>
                          <td>{{ number_format($facture->facture_partpdv, 0, ',', ' ') }} FCFA</td> 
                          <td class="text-center">
                            @if($facture->facture_statut_paiement == 'PAYE')
								<img src="{{ asset('assets/images/paye.png') }}" width="65" title="RÉSERVATION PAYÉE">
                            @elseif($facture->facture_statut_paiement == 'IMPAYE')
								<img src="{{ asset('assets/images/impayeicon.png') }}" width="50" title="RÉSERVATION IMPAYÉE">
                            @elseif($facture->facture_statut_paiement == 'ANNULE')
								<img src="{{ asset('assets/images/annuler-icon.png') }}" width="70" title="RÉSERVATION ANNULÉE">
                            @elseif($facture->facture_statut_paiement == 'ANNULE')
								<img src="{{ asset('assets/images/annuler-icon.png') }}" width="70" title="RÉSERVATION ANNULÉE">
                            @elseif($facture->facture_statut_paiement == 'EN ATTENTE')
								<img src="{{ asset('assets/images/attente.png') }}" width="40" title="RÉSERVATION EN ATTENTE D'ANNULATION">
                            @endif
                          </td>
                          <td class="text-center">
                            @if($facture->facture_statut_paiement == 'PAYE')
								<span data-toggle="modal" data-target="#modal-xl-{{$facture->facture_id}}" title="DÉTAILS DE LA RÉSERVATION"><img src="{{ asset('assets/images/details.png') }}" width="18"></span>                                            
								<span data-toggle="modal" class="ml-1" data-target="#modal-default-{{$facture->facture_id}}" title="ANNULER LA RÉSERVATION"><img src="{{ asset('assets/images/cancel.png') }}" width="18"></span>
                            @elseif($facture->facture_statut_paiement == 'IMPAYE')
								<span data-toggle="modal" data-target="#modal-xl-{{$facture->facture_id}}" title="DÉTAILS DE LA RÉSERVATION"><img src="{{ asset('assets/images/details.png') }}" width="18"></span>
								<a href="" title="FINALISER LE PAIEMENT"><img src="{{ asset('assets/images/valider.png') }}" width="30"></a>
                            @elseif($facture->facture_statut_paiement == 'EN ATTENTE')
								<span data-toggle="modal" data-target="#modal-xl-{{$facture->facture_id}}" title="DÉTAILS DE LA RÉSERVATION"><img src="{{ asset('assets/images/details.png') }}" width="18"></span>
							@elseif($facture->facture_statut_paiement == 'ANNULE')
								<span data-toggle="modal" data-target="#modal-xl-{{$facture->facture_id}}" title="DÉTAILS DE LA RÉSERVATION"><img src="{{ asset('assets/images/details.png') }}" width="18"></span>
							@endif
                          </td>

                          <div class="modal fade" id="modal-xl-{{$facture->facture_id}}">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Détails de la réservation : {{ $facture->facture_numero }}</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-12 col-sm-12">
                                      <div class="card card-primary card-tabs">
                                        <div class="card-header p-0 pt-1">
                                          <ul class="nav nav-tabs text-uppercase" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item">
                                              <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home-{{$facture->facture_id}}" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Infos générales</a>
                                            </li>
                                            <li class="nav-item">
                                              <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile-{{$facture->facture_id}}" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Infos Client</a>
                                            </li>
                                          </ul>
                                        </div>
                                        <div class="card-body">
                                          <div class="tab-content" id="custom-tabs-one-tabContent">
                                            <div class="tab-pane fade show active" id="custom-tabs-one-home-{{$facture->facture_id}}" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                              <div class="row">
                                                  <div class="col-md-6">
                                                      <p><span style="font-weight:bold">Référence :</span> {{ $facture->facture_numero }}</p>
                                                      <p><span style="font-weight:bold">Gain :</span> {{ number_format($facture->facture_partpdv, 0, ',', ' ') }}  FCFA</p>
                                                      <p><span style="font-weight:bold">Statut :</span>
                                                        @if($facture->facture_statut_paiement == 'PAYE')
                                                            <span class="badge badge-success">Payée</span>
                                                        @elseif($facture->facture_statut_paiement == 'BROUILLON')
                                                            <span class="badge badge-warning">En cours</span>
                                                        @elseif($facture->facture_statut_paiement == 'ANNULE')
                                                            <span class="badge badge-danger">Annulé</span>
                                                        @elseif($facture->facture_statut_paiement == 'IMPAYE')
                                                            <span class="badge badge-danger">Impayée</span>
                                                        @endif
                                                      </p>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <p><span style="font-weight:bold">Destination :</span> {{ $facture->ligne_designation }}</p>
                                                      <p><span style="font-weight:bold">Date de paiement :</span> {{ \Carbon\Carbon::parse($facture->facture_date_paiement)->format('d-m-Y')}}</p>
                                                  </div>
                                              </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-profile-{{$facture->facture_id}}" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                               <div class="row">
                                                  <div class="col-md-6">
                                                      <p><span style="font-weight:bold">Nom & Prénoms :</span> {{ $facture->client_nom }} {{ $facture->client_prenoms }}</p>
                                                      <p><span style="font-weight:bold">Numéro d'embarquement :</span> <span style="color:green; font-weight:bold">{{ $facture->client_code }}</span></p>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <p><span style="font-weight:bold">Téléphone :</span> +225 {{ $facture->client_telephone }}</p>
                                                      @if($facture->client_email !=null)<p><span style="font-weight:bold">Adresse Email :</span> {{ $facture->client_email }}</p>@endif
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- /.card -->
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <p></p>
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal fade" id="modal-default-{{$facture->facture_id}}">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Demande d'annulation : {{ $facture->facture_numero }}</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="{{ route('annuler.reservation',$facture->facture_id) }}" method="POST">
                                  @csrf
                                  <div class="modal-body">
                                    <div class="form-group">
                                      <label>Motif de la demande</label>
                                      <textarea class="form-control" rows="3" name="deamnde" placeholder="Entrer le motif..."></textarea>
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
      <form action="{{ route('pointvente.ticket-export.excel') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Date Départ</label>
            <input type="date" class="form-control" name="start_date">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Date Fin</label>
            <input type="date" class="form-control" name="end_date">
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
      <form action="{{ route('pointvente.ticket-export.pdf') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Date Départ</label>
            <input type="date" class="form-control" name="start_date">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Date Fin</label>
            <input type="date" class="form-control" name="end_date">
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