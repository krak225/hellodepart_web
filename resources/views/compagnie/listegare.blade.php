@extends('layouts.admin')
@section('title')
  Liste des gares
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des gares</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des gares</li>
                        <li class="breadcrumb-item">Liste des gares</li>
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
                <h3 class="card-title">Liste des gares</h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a href="" class="badge badge-warning float-end mr-2" data-toggle="modal" data-target="#EnregistrerGare">Nouvelle Gare</a></li>
                    @if($gares->count() > 0)
                      <li class="page-item"><a href="" class="badge badge-success float-end mr-2">Exporter Excel</a></li>
                      <li class="page-item"><a href="" class="badge badge-primary float-end">Exporter PDF</a></li>
                    @endif
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Designation</th>
                      <th>Réprésentant</th>
                      <th>Téléphone</th>
                      <th>Email</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($gares as $gare)
                      <tr>
                        <td>{{ $gare->gare_designation }}</td>
                        <td>{{ $gare->gare_nom_responsable }}</td>
                        <td>{{ $gare->gare_numero_mobile }}</td>
                        <td>{{ $gare->email }}</td>
                        <td class="text-center">
                          <img src="{{ asset('assets/images/modifier.png') }}" width="20" title="MODIFIER LE COMPTE">
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="DETAILS DU COMPTE" class="SupprimerGare" data-url="{{ route('compagnie.supprimer.gare',$gare->gare_id) }}" data-id="{{ $gare->gare_id }}" data-name="{{ $gare->gare_designation }}">                       
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

<div class="modal fade" id="EnregistrerGare">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Créer une nouvelle gare</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
           <form action="{{ route('compagnie.save.gare') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">               
                  <div class="card-body">                           
                      <div class="row">
                          <div class="col-md-6 mb-4">
                              <label for="" class="form-label">Désignation <span style="color:red">*</span></label>
                              <input type="text" required class="form-control @error('designation') is-invalid @enderror" name="designation" placeholder="Entrer la désignation" value="{{ old('designation') }}" onkeyup="this.value=this.value.toUpperCase()">
                          </div>
                          <div class="col-md-6 mb-4">
                              <label for="" class="form-label">Nom du responsable <span style="color:red">*</span></label>
                              <input type="text" required class="form-control @error('nom_responsable') is-invalid @enderror" name="nom_responsable" placeholder="Entrer le nom du responsable" value="{{ old('nom_responsable') }}" onkeyup="this.value=this.value.toUpperCase()">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6 mb-4">
                              <label for="" class="form-label">Adresse géographique <span style="color:red">*</span></label>
                              <input type="text" required class="form-control @error('adresse_siege') is-invalid @enderror" name="adresse_siege" placeholder="Entrer l'adresse du siège" value="{{ old('adresse_siege') }}" onkeyup="this.value=this.value.toUpperCase()">
                          </div>
                          <div class="col-md-6 mb-4">
                              <label for="" class="form-label">Téléphone du bureau</label>
                              <input type="text" class="form-control" name="phone_bureau" id="phone_bureau" placeholder="Entrer le numéro de téléphone du bureau" value="{{ old('phone_bureau') }}" onkeypress="isInputNumber(event)">
                          </div>
                      </div>
                      <div class="row">                            
                          <div class="col-md-4 mb-4">
                              <label for="" class="form-label">Téléphone mobile <span style="color:red">*</span></label>
                              <input type="text" required class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" placeholder="Entrer le numéro de téléphone mobile" value="{{ old('mobile') }}" onkeypress="isInputNumber(event)">
                          </div>                            
                          <div class="col-md-4 mb-4">
                              <label for="" class="form-label">Fax</label>
                              <input type="text" class="form-control" name="fax" id="fax" placeholder="Entrer le fax" value="{{ old('fax') }}" onkeypress="isInputNumber(event)">
                          </div>
                          <div class="col-md-4 mb-4">
                              <label for="" class="form-label">Adresse email <span style="color:red">*</span></label>
                              <input type="email" required class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Entrer l'adresse email" value="{{ old('email') }}">
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