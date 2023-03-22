@extends('layouts.admin')
@section('title')
	Liste des voyages effectués
@endsection
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Liste des voyages effectuéss</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item">Gestion des voyages</li>
            <li class="breadcrumb-item">Historique des voyages</li>
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
              <h3 class="card-title">Liste des voyages effectués</h3>
              <div class="card-tools">
                <ul class="pagination pagination-sm float-right">
                  @if($voyages->count() > 0)
                    <li class="page-item"><a href="" class="btn btn-success float-end mr-2">Exporter Excel</a></li>
                    <li class="page-item"><a href="" class="btn btn-primary float-end">Exporter PDF</a></li>
                  @endif
                </ul>
              </div>
            </div>
            <div class="card-body">
              	<table id="example2" class="table table-bordered table-hover">
                	<thead>
	                    <tr>
	                      	<th>N° Journée</th>
	                      	<th>Trajet</th>
	                      	<th>Gare</th>
	                      	<th>Véhicule</th>
	                      	<th class="text-center">Détails</th>
	                    </tr>
                	</thead>
                	<tbody>
	                    @foreach($voyages as $voyage)
	                      	<tr>
		                        <td>{{ $voyage->voyage_numero_journee }}</td>
		                        <td>{{ $voyage->trajet_depart }} -- {{ $voyage->trajet_arrive }}</td>
		                        <td>{{ $voyage->gare_designation }}</td>
		                        <td>{{ $voyage->vehicule_numero }}</td>
		                        <td class="text-center">
		                          	<a href="{{ route('compagnie.details.historique.voyage', [$voyage->voyage_id, Stdfn::clean_url($voyage->trajet_depart.$voyage->trajet_arrive)]) }}"><img src="{{ asset('assets/images/details.png') }}" width="26" style=""></a>
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