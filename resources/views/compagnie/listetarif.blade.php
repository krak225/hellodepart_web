@extends('layouts.admin')
@section('title')
  Liste des tarifs
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des tarifs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des tarifs</li>
                        <li class="breadcrumb-item">Liste des tarifs</li>
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
                <h3 class="card-title">Liste des tarifs</h3>
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-right">
                    <li class="page-item"><a href="" class="badge badge-warning float-end mr-2" data-toggle="modal" data-target="#EnregistrerTarif">Nouveau Tarif</a></li>
                    @if($tarifs->count() > 0)
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
                      <th>Ligne</th>
                      <th>Montant</th>
                      <th>Commission</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($tarifs as $tarif)
                      <tr>
                        <td>{{ $tarif->ligne_designation }}</td>
                        <td>{{ number_format($tarif->tarif_montant, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($tarif->tarif_fraiscommission, 0, ',', ' ') }} FCFA</td>
                        <td class="text-center">
                          <a href="" data-toggle="modal" data-target="#ModifierLigne-{{ $tarif->tarif_id }}"><img src="{{ asset('assets/images/modifier.png') }}" width="20" title="MODIFIER LE TARIF"></a>
                          <img src="{{ asset('assets/images/cancel.png') }}" width="20" title="SUPPRIMER LE TARIF" class="SupprimerTarif" data-url="{{ route('compagnie.supprimer.tarif',$tarif->tarif_id) }}" data-name="{{ $tarif->ligne_designation }} de {{ number_format($tarif->tarif_montant, 0, ',', ' ') }} FCFA">                       
                        </td>
                      </tr>
                      <div class="modal fade" id="ModifierLigne-{{ $tarif->tarif_id }}">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Modifier : {{ $tarif->ligne_designation }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                 <form action="{{ route('compagnie.modifier.tarif',$tarif->tarif_id) }}" method="POST" enctype="multipart/form-data">
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
                                                  @foreach($lignes as $ligne)
                                                    <option @if($tarif->ligne_id == $ligne->ligne_id) selected @endif value="{{ $ligne->ville_id }}">{{ $ligne->ville_libelle }}</option>
                                                  @endforeach
                                                </select>
                                              </div>
                                              <div class="col-md-4 mb-4">
                                                <label for="" class="form-label">Kilométrage</label>
                                                <input type="text" class="form-control" name="kilometrage" placeholder="Entrer le kilométrage" value="{{ $tarif->ligne_kilometrage }}" onkeypress="isInputNumber(event)">
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
  <div class="modal fade" id="EnregistrerTarif">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer une nouveau tarif</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <form action="{{ route('compagnie.save.tarif') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">               
                    <div class="card-body">
                        <div class="row">                
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Ligne <span style="color:red">*</span></label>
                            <select required class="form-control select2bs4 @error('ligne_id') is-invalid @enderror" name="ligne_id" data-placeholder="Choisissez une ligne..." >
                              <option value=""></option>
                              @foreach($lignes as $ligne)
                                <option value="{{ $ligne->ligne_id }}">{{ $ligne->ligne_designation }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Montant <span style="color:red">*</span></label>
                            <input type="text" class="form-control" required name="montant" value="{{ old('montant') }}" placeholder="Entrer le montant" onkeypress="isInputNumber(event)">
                          </div>
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Commision <span style="color:red">*</span></label>
                            <input type="text" class="form-control" required name="commission" placeholder="Entrer la commission" value="{{ old('commission') }}" onkeypress="isInputNumber(event)">
                          </div>
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Date début <span style="color:red">*</span></label>
                            <input type="date" class="form-control" required name="start_date" min="<?php echo(gmdate('Y-m-d')) ?>" value="{{ old('start_date') }}">
                          </div>
                          <div class="col-md-4 mb-4">
                            <label for="" class="form-label">Date fin <span style="color:red">*</span></label>
                            <input type="date" class="form-control" required name="end_date" min="<?php echo(gmdate('Y-m-d')) ?>" value="{{ old('end_date') }}">
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