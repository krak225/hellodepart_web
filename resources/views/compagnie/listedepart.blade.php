@extends('layouts.admin')
@section('title')
  Liste des départs
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des départs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des départs</li>
                        <li class="breadcrumb-item">Liste des départs</li>
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
                <table id="example2" class="table table-bordered table-hover">
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
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="SUPPRIMER UN DEPART" class="SupprimerDepart" data-url="{{ route('compagnie.supprimer.ligne',$depart->depart_id) }}" data-name="{{ $depart->ligne_designation }}">                       
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
             <form action="{{ route('compagnie.save.depart') }}" method="POST" enctype="multipart/form-data">
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
<script>  
function isInputNumber(evt){
      
  var ch = String.fromCharCode(evt.which);
  
  if(!(/[0-9]/.test(ch))){
      evt.preventDefault();
  }        
}  
</script>
@endsection