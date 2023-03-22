@extends('layouts.admin')
@section('title')
    Créer une nouvelle gare
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Créer une nouvelle gare</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des gares</li>
                        <li class="breadcrumb-item">Nouvelle gare</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Créer une nouvelle gare</h3>
                </div>
                <form action="{{ route('admin.save.nouvelle.gare') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">                           
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="form-label">Désignation <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" placeholder="Entrer la désignation" value="{{ old('designation') }}" onkeyup="this.value=this.value.toUpperCase()">
                            </div>
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Nom du responsable <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('nom_responsable') is-invalid @enderror" name="nom_responsable" placeholder="Entrer le nom du responsable" value="{{ old('nom_responsable') }}" onkeyup="this.value=this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="form-label">Adresse géographique <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('adresse_siege') is-invalid @enderror" name="adresse_siege" placeholder="Entrer l'adresse du siège" value="{{ old('adresse_siege') }}" onkeyup="this.value=this.value.toUpperCase()">
                            </div>
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Téléphone du bureau</label>
                                <input type="text" class="form-control" name="phone_bureau" id="phone_bureau" placeholder="Entrer le numéro de téléphone du bureau" value="{{ old('phone_bureau') }}" onkeypress="isInputNumber(event)">
                            </div>
                        </div>
                        <div class="row">                            
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Téléphone mobile <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" placeholder="Entrer le numéro de téléphone mobile" value="{{ old('mobile') }}" onkeypress="isInputNumber(event)">
                            </div>                            
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Fax</label>
                                <input type="text" class="form-control" name="fax" id="fax" placeholder="Entrer le fax" value="{{ old('fax') }}" onkeypress="isInputNumber(event)">
                            </div>
                        </div>
                        <div class="row">                              
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Adresse email <span style="color:red">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Entrer l'adresse email" value="{{ old('email') }}">
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
        const faxInput = document.getElementById("fax");
        const mobileInput = document.getElementById("mobile");
        const phonebureauInput = document.getElementById("phone_bureau");

        // Définition de la limite de saisie à une caractère
        faxInput.maxLength = 10;
        mobileInput.maxLength = 10;
        phonebureauInput.maxLength = 10;
    </script>
@endsection