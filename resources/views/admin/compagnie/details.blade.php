@extends('layouts.admin')
@section('title')
    Détails de : {{ $compagnie->compagnie_designation }}
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Détails de : {{ $compagnie->compagnie_designation }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des compagnies</li>
                        <li class="breadcrumb-item">Détails</li>
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
                <h3 class="card-title">Liste des départ</h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a href="" class="badge badge-warning float-end mr-2" data-toggle="modal" data-target="#EnregistrerLigne">Nouveau départ</a></li>
                    @if($departs->count() > 0)
                      <!--li class="page-item"><a href="" class="badge badge-success float-end mr-2">Exporter Excel</a></li>
                      <li class="page-item"><a href="" class="badge badge-primary float-end">Exporter PDF</a></li-->
                    @endif
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <table id="example4" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Designation</th>
                      <th>Gare</th>
                      <th>Véhicule</th>
                      <th>Date départ</th>
                      <th>Heure départ</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($departs as $depart)
                      <tr>
                        <td>{{ $depart->ligne_designation }}</td>
                        <td>{{ $depart->gare_designation }}</td>
                        <td>{{ $depart->vehicule_marque }} - {{ $depart->vehicule_modele }}</td>
                        <td>{{ \Carbon\Carbon::parse($depart->depart_date_arrivee)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($depart->depart_heure_prevue)->format('H:i') }}</td>
                        <td class="text-center">
                          <a href="" data-toggle="modal" data-target="#ModifierDepart-{{ $depart->depart_id }}"><img src="{{ asset('assets/images/modifier.png') }}" width="20" title="MODIFIER LE DEPART"></a>
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="SUPPRIMER UN DEPART" class="SupprimerDepart" data-url="{{ route('admin.supprimer.ligne',$depart->depart_id) }}" data-name="{{ $depart->ligne_designation }}">                       
                        </td>
                      </tr>
                      <div class="modal fade" id="ModifierDepart-{{ $depart->depart_id }}">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Modifier : {{ $depart->ligne_designation }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                 <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">               
                                        <div class="card-body">
                                            <div class="row">                            
                                              <div class="col-md-4 mb-4">
                                                <label for="" class="form-label">Ville Départ <span style="color:red">*</span></label>
                                                <select required class="form-control select2bs4 @error('ville_id01') is-invalid @enderror" name="ville_id01" data-placeholder="Choisissez une ville..." >
                                                  <option value=""></option>
                                                  
                                                </select>
                                              </div>                            
                                              <div class="col-md-4 mb-4">
                                                <label for="" class="form-label">Ville Destination <span style="color:red">*</span></label>
                                                <select required class="form-control select2bs4 @error('ville_id02') is-invalid @enderror" name="ville_id02" data-placeholder="Choisissez une ville..." >
                                                  <option value=""></option>
                                                  
                                                </select>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label for="" class="form-label">Kilométrage</label>
                                                <input type="text" class="form-control" name="kilometrage" placeholder="Entrer le kilométrage" value="{{ old('kilometrage') }}" onkeypress="isInputNumber(event)">
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
                    @endforeach
                  </tbody>
                </table>
              </div>
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
                <h3 class="card-title">Liste des lignes</h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a href="" class="badge badge-warning float-end mr-2" data-toggle="modal" data-target="#EnregistrerLigne">Nouvelle Ligne</a></li>
                    @if($lignes->count() > 0)
                      <!--li class="page-item"><a href="" class="badge badge-success float-end mr-2">Exporter Excel</a></li>
                      <li class="page-item"><a href="" class="badge badge-primary float-end">Exporter PDF</a></li-->
                    @endif
                  </ul>
                </div>
              </div>
              <div class="card-body">
                <table id="example3" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Designation</th>
                      <th>Kilometrage</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($lignes as $ligne)
                      <tr>
                        <td>{{ $ligne->ligne_designation }}</td>
                        <td>{{ $ligne->ligne_kilometrage }}</td>
                        <td class="text-center">
                          <a href="" data-toggle="modal" data-target="#ModifierLigne-{{ $ligne->ligne_id }}"><img src="{{ asset('assets/images/modifier.png') }}" width="20" title="MODIFIER LA LIGNE"></a>
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="SUPPRIMER LA LIGNE" class="SupprimerLigne" data-url="{{ route('admin.supprimer.ligne',$ligne->ligne_id) }}" data-name="{{ $ligne->ligne_designation }}">                       
                        </td>
                      </tr>
                      <div class="modal fade" id="ModifierLigne-{{ $ligne->ligne_id }}">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Modifier : {{ $ligne->ligne_designation }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                 <form action="{{ route('admin.modifier.ligne',$ligne->ligne_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">               
                                        <div class="card-body">
                                            <div class="row">                            
                                              <div class="col-md-4 mb-4">
                                                <label for="" class="form-label">Ville Départ <span style="color:red">*</span></label>
                                                <select required class="form-control select2bs4 @error('ville_id01') is-invalid @enderror" name="ville_id01" data-placeholder="Choisissez une ville..." >
                                                  <option value=""></option>
                                                  @foreach($villes as $ville)
                                                    <option @if($ligne->ville_id01 == $ville->ville_id) selected @endif value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                                  @endforeach
                                                </select>
                                              </div>                            
                                              <div class="col-md-4 mb-4">
                                                <label for="" class="form-label">Ville Destination <span style="color:red">*</span></label>
                                                <select required class="form-control select2bs4 @error('ville_id02') is-invalid @enderror" name="ville_id02" data-placeholder="Choisissez une ville..." >
                                                  <option value=""></option>
                                                  @foreach($villes as $ville)
                                                    <option @if($ligne->ville_id02 == $ville->ville_id) selected @endif value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                                  @endforeach
                                                </select>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label for="" class="form-label">Kilométrage</label>
                                                <input type="text" class="form-control" name="kilometrage" placeholder="Entrer le kilométrage" value="{{ $ligne->ligne_kilometrage }}" onkeypress="isInputNumber(event)">
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
                    @endforeach
                  </tbody>
                </table>
              </div>
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
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="DETAILS DU COMPTE" class="SupprimerGare" data-url="{{ route('admin.supprimer.gare',$gare->gare_id) }}" data-id="{{ $gare->gare_id }}" data-name="{{ $gare->gare_designation }}">                       
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
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="DETAILS DU VÉHICULE" class="SupprimerVehicule" data-url="{{ route('admin.supprimer.vehicule',$vehicule->vehicule_id) }}" data-id="{{ $vehicule->vehicule_id }}" data-name="{{ $vehicule->vehicule_numero }}">                          
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
             <form action="{{ route('admin.save.gare',$compagnie->compagnie_id) }}" method="POST" enctype="multipart/form-data">
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
<div class="modal fade" id="EnregistrerVehicule">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer un nouveau véhicule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form action="{{ route('admin.save.vehicule',$compagnie->compagnie_id) }}" method="POST" enctype="multipart/form-data">
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
<div class="modal fade" id="EnregistrerLigne">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer une nouvelle ligne</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form action="{{ route('admin.save.ligne',$compagnie->compagnie_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">               
                    <div class="card-body">
                        <div class="row">                            
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Ville Départ <span style="color:red">*</span></label>
                            <select required class="form-control select2bs4 @error('ville_id01') is-invalid @enderror" name="ville_id01" data-placeholder="Choisissez une ville..." >
                              <option value=""></option>
                              @foreach($villes as $ville)
                                <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                              @endforeach
                            </select>
                          </div>                            
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Ville Destination <span style="color:red">*</span></label>
                            <select required class="form-control select2bs4 @error('ville_id02') is-invalid @enderror" name="ville_id02" data-placeholder="Choisissez une ville..." >
                              <option value=""></option>
                              @foreach($villes as $ville)
                                <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Kilométrage</label>
                            <input type="text" class="form-control" name="kilometrage" placeholder="Entrer le kilométrage" value="{{ old('kilometrage') }}" onkeypress="isInputNumber(event)">
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
<div class="modal fade" id="EnregistrerLigne">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer une nouvelle ligne</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form action="{{ route('admin.save.depart') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">               
                    <div class="card-body">
                        <div class="row">                            
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Ville Départ <span style="color:red">*</span></label>
                            <select required class="form-control select2bs4 @error('ville_id01') is-invalid @enderror" name="ville_id01" data-placeholder="Choisissez une ville..." >
                              <option value=""></option>
                              
                            </select>
                          </div>                            
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Ville Destination <span style="color:red">*</span></label>
                            <select required class="form-control select2bs4 @error('ville_id02') is-invalid @enderror" name="ville_id02" data-placeholder="Choisissez une ville..." >
                              <option value=""></option>
                              
                            </select>
                          </div>
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Kilométrage</label>
                            <input type="text" class="form-control" name="kilometrage" placeholder="Entrer le kilométrage" value="{{ old('kilometrage') }}" onkeypress="isInputNumber(event)">
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