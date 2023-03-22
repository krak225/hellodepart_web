@extends('layouts.admin')
@section('title')
    Liste des compagnies
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des compagnies</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des compagnies</li>
                        <li class="breadcrumb-item">Liste des compagnies</li>
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
                <h3 class="card-title">Liste des compagnies</h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a href="" class="badge badge-warning float-end mr-2" data-toggle="modal" data-target="#EnregistrerCompagnie">Nouvelle Compagnie</a></li>
                    @if($compagnies->count() > 0)
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
                    @foreach($compagnies as $compagnie)
                      <tr>
                        <td>{{ $compagnie->compagnie_designation }}</td>
                        <td>{{ $compagnie->compagnie_representant }}</td>
                        <td>{{ $compagnie->compagnie_mobile }}</td>
                        <td>{{ $compagnie->compagnie_email }}</td>
                        <td class="text-center">
                          <a href="{{ route('admin.details.compagnie', [$compagnie->compagnie_id, Stdfn::clean_url($compagnie->compagnie_designation)]) }}"><img src="{{ asset('assets/images/details.png') }}" width="20" title="DETAILS DU COMPTE" style=""></a>
                          <img src="{{ asset('assets/images/modifier.png') }}" width="20" title="MODIFIER LE COMPTE" style="">
                          <span class="SupprimerCompagnie" data-url="{{ route('admin.supprimer.compagnie',$compagnie->compagnie_id) }}" data-name="{{ $compagnie->compagnie_designation }}"><img src="{{ asset('assets/images/cancel.png') }}" width="20" title="DETAILS DU COMPTE" style=""></span>						  
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
<div class="modal fade" id="EnregistrerCompagnie">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer une nouvelle compagnie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form action="{{ route('admin.save.compagnie') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">               
                  <div class="card-body">                          
                    <div class="row">
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Désignation <span style="color:red">*</span></label>
                        <input type="text" required class="form-control @error('designation') is-invalid @enderror" name="designation" placeholder="Entrer la désignation" value="{{ old('designation') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Nom réprésentant <span style="color:red">*</span></label>
                        <input type="text" required class="form-control @error('nom_representant') is-invalid @enderror" name="nom_representant" placeholder="Entrer le nom du réprésentant" value="{{ old('nom_representant') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Adresse géographique du siège <span style="color:red">*</span></label>
                        <input type="text" required class="form-control @error('adresse_siege') is-invalid @enderror" name="adresse_siege" placeholder="Entrer l'adresse du siège" value="{{ old('adresse_siege') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>
                    </div>
                    <div class="row">                        
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Téléphone du bureau</label>
                        <input type="text" class="form-control" name="phone_bureau" id="phone_bureau" placeholder="Entrer le numéro de téléphone du bureau" value="{{ old('phone_bureau') }}" onkeypress="isInputNumber(event)">
                      </div>
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Téléphone mobile <span style="color:red">*</span></label>
                        <input type="text" required class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" placeholder="Entrer le numéro de téléphone mobile" value="{{ old('mobile') }}" onkeypress="isInputNumber(event)">
                      </div>                            
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Fax</label>
                        <input type="text" class="form-control" name="fax" id="fax" placeholder="Entrer le fax" value="{{ old('fax') }}" onkeypress="isInputNumber(event)">
                      </div>
                    </div>
                    <div class="row">                            
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Boite postale</label>
                        <input type="text" class="form-control" name="bp" placeholder="Entrer l'adresse de la boite postale" value="{{ old('bp') }}" onkeyup="this.value=this.value.toUpperCase()">
                      </div>                            
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Adresse email <span style="color:red">*</span></label>
                        <input type="email" required class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Entrer l'adresse email" value="{{ old('email') }}">
                      </div>
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Ville de siège <span style="color:red">*</span></label>
                        <select required class="form-control select2bs4 @error('ville_id') is-invalid @enderror" name="ville_id" data-placeholder="Choisissez une ville..." >
                          <option value=""></option>
                          @foreach($villes as $ville)
                            <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Logo <span style="color:red">*</span></label>
                        <input type="file" required class="form-control @error('logo') is-invalid @enderror" name="logo">
                      </div>
                      <div class="col-md-4 mb-4">
                        <label for="" class="form-label">Mot de passe <span style="color:red">*</span></label>
                        <input type="password" required class="form-control @error('password') is-invalid @enderror" name="password" placeholder="******">
                      </div>
                      <div class="col-md-4">
                        <label for="" class="form-label">Confirmer le mot de passe<span style="color:red">*</span></label>
                        <input type="password" required class="form-control @error('password') is-invalid @enderror" name="password_confirmation" id="password-confirm" placeholder="******">
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
<script>  
	function isInputNumber(evt){
        
        var ch = String.fromCharCode(evt.which);
        
        if(!(/[0-9]/.test(ch))){
            evt.preventDefault();
        }        
    }  
</script>
<script>
        function isInputNumber(evt){
            
            var ch = String.fromCharCode(evt.which);
            
            if(!(/[0-9]/.test(ch))){
                evt.preventDefault();
            }        
        } 

        // Récupération de l'élément HTML input
        const telephoneInput = document.getElementById("telephone");

        // Définition de la limite de saisie à une caractère
        telephoneInput.maxLength = 10;
    </script>
@endsection