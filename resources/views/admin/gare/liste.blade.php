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
                    @if($gares->count() > 0)
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
                      <th></th>
                      <th>Designation</th>
                      <th>Réprésentant</th>
                      <th>Compagnie</th>
                      <th>Téléphone</th>
                      <th>Email</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($gares as $gare)
                      <tr>
                        <td><img src="{{ asset('assets/images/details.png') }}" width="20" style=""></td>
                        <td>{{ $gare->gare_designation }}</td>
                        <td>{{ $gare->gare_nom_responsable }}</td>
                        <td>{{ $gare->compagnie_designation }}</td>
                        <td>{{ $gare->gare_numero_mobile }}</td>
                        <td>{{ $gare->email }}</td>
                        <td class="text-center">
                          <img src="{{ asset('assets/images/details.png') }}" width="20" title="DETAILS DU COMPTE">
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