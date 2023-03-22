@extends('layouts.admin')
@section('title')
    Créer un nouveau véhicule
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Créer un nouveau véhicule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des gares</li>
                        <li class="breadcrumb-item">Nouveau véhicule</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Créer un nouveau véhicule</h3>
                </div>
                <form action="{{ route('admin.save.nouveau.vehicule') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Capacité du véhicule <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('capacite') is-invalid @enderror" name="capacite" placeholder="Entrer la capacité du véhicule" value="{{ old('capacite') }}" onkeypress="isInputNumber(event)">
                            </div>                            
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Caratéristique du véhicule <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('carateristique') is-invalid @enderror" name="carateristique" placeholder="Entrer la caratéristique du véhicule" value="{{ old('carateristique') }}" onkeyup="this.value=this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="row">                              
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Image du véhicule <span style="color:red">*</span></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="" class="form-label">Compagnie<span style="color:red">*</span></label>
                                <select class="form-control select2bs4 @error('compagnie_id') is-invalid @enderror" name="compagnie_id" data-placeholder="Choisissez une compagnie..." >
                                    <option value=""></option>
                                    @foreach($compagnies as $compagnie)
                                        <option value="{{ $compagnie->compagnie_id }}">{{ $compagnie->compagnie_designation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Créer le compte</button>
                    </div>
                </form>
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
        const capaciteInput = document.getElementById("capacite");

        // Définition de la limite de saisie à une caractère
        capaciteInput.maxLength = 10;
    </script>
@endsection