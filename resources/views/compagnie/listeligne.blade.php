@extends('layouts.admin')
@section('title')
  Liste des lignes
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des lignes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des lignes</li>
                        <li class="breadcrumb-item">Liste des lignes</li>
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
                <table id="example2" class="table table-bordered table-hover">
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
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="SUPPRIMER LA LIGNE" class="SupprimerLigne" data-url="{{ route('compagnie.supprimer.ligne',$ligne->ligne_id) }}" data-name="{{ $ligne->ligne_designation }}">                       
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
                                 <form action="{{ route('compagnie.modifier.ligne',$ligne->ligne_id) }}" method="POST" enctype="multipart/form-data">
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
             <form action="{{ route('compagnie.save.ligne') }}" method="POST" enctype="multipart/form-data">
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
  <script>  
    function isInputNumber(evt){
          
      var ch = String.fromCharCode(evt.which);
      
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }        
    }  
  </script>
@endsection