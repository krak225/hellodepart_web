@extends('layouts.admin')
@section('title')
  Liste des véhicules
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des véhicules</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des véhicules</li>
                        <li class="breadcrumb-item">Liste des véhicules</li>
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
                <h3 class="card-title">Liste des véhicules</h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a href="" class="badge badge-warning float-end mr-2" data-toggle="modal" data-target="#EnregistrerVehicule">Nouveau Véhicule</a></li>
                    @if($vehicules->count() > 0)
                      <li class="page-item"><a href="" class="badge badge-success float-end mr-2">Exporter Excel</a></li>
                      <li class="page-item"><a href="" class="badge badge-primary float-end">Exporter PDF</a></li>
                    @endif
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Numéro</th>
                      <th>Immatriculation</th>
                      <th>Marque</th>
                      <th>Modèle</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($vehicules as $vehicule)
                      <tr>
                        <td>{{ $vehicule->vehicule_numero }}</td>
                        <td>{{ $vehicule->vehicule_immatriculation }}</td>
                        <td>{{ $vehicule->vehicule_marque }}</td>
                        <td>{{ $vehicule->vehicule_modele }}</td>
                        <td class="text-center">
                          <img src="{{ asset('assets/images/modifier.png') }}" width="20" title="MODIFIER LE VÉHICULE">
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="DETAILS DU VÉHICULE" class="SupprimerVehicule" data-url="{{ route('compagnie.supprimer.vehicule',$vehicule->vehicule_id) }}" data-name="{{ $vehicule->vehicule_numero }}">                          
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

<div class="modal fade" id="EnregistrerVehicule">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Créer un nouveau véhicule</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
           <form action="{{ route('compagnie.save.vehicule') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">               
                <div class="card-body">                           
                  <div class="row">
                      <div class="col-md-6 mb-4">
                          <label for="" class="form-label">Numéro du véhicule <span style="color:red">*</span></label>
                          <input type="text" class="form-control @error('numero_car') is-invalid @enderror" name="numero_car" placeholder="Entrer le numéro du car" value="{{ old('numero_car') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>
                      <div class="col-md-6 mb-4">
                          <label for="" class="form-label">Numéro d'immatriculation <span style="color:red">*</span></label>
                          <input type="text" class="form-control @error('immatriculation') is-invalid @enderror" name="immatriculation" placeholder="Entrer le numéro d'immatriculation" value="{{ old('immatriculation') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6 mb-4">
                          <label for="" class="form-label">Marque <span style="color:red">*</span></label>
                          <input type="text" class="form-control @error('marque') is-invalid @enderror" name="marque" placeholder="La marque du véhicule" value="{{ old('marque') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>
                      <div class="col-md-6 mb-4">
                          <label for="" class="form-label">Modèle <span style="color:red">*</span></label>
                          <input type="text" class="form-control @error('modele') is-invalid @enderror" name="modele" placeholder="Entrer le modèle" value="{{ old('modele') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>
                  </div>
                  <div class="row">                            
                      <div class="col-md-4 mb-4">
                          <label for="" class="form-label">Capacité du véhicule <span style="color:red">*</span></label>
                          <input type="text" class="form-control @error('capacite') is-invalid @enderror" name="capacite" placeholder="Entrer la capacité du véhicule" value="{{ old('capacite') }}" onkeypress="isInputNumber(event)">
                      </div>                            
                      <div class="col-md-4 mb-4">
                          <label for="" class="form-label">Caratéristique du véhicule <span style="color:red">*</span></label>
                          <input type="text" class="form-control @error('carateristique') is-invalid @enderror" name="carateristique" placeholder="Entrer la caratéristique du véhicule" value="{{ old('carateristique') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>                              
                      <div class="col-md-4 mb-4">
                          <label for="" class="form-label">Image du véhicule <span style="color:red">*</span></label>
                          <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                      </div>
                  </div>
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