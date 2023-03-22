@extends('layouts.admin')
@section('title')
    Créer une nouvelle compagnie
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Créer une nouvelle compagnie</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des compagnies</li>
                        <li class="breadcrumb-item">Nouvelle compagnie</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Créer une nouvelle compagnie</h3>
                </div>
                <form action="{{ route('admin.save.nouvelle.compagnie') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">                           
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="form-label">Désignation <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" placeholder="Entrer la désignation" value="{{ old('designation') }}" onkeyup="this.value=this.value.toUpperCase()">
                            </div>
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Nom réprésentant <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('nom_representant') is-invalid @enderror" name="nom_representant" placeholder="Entrer le nom du réprésentant" value="{{ old('nom_representant') }}" onkeyup="this.value=this.value.toUpperCase()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="form-label">Adresse géographique du siège <span style="color:red">*</span></label>
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
                                <label for="" class="form-label">Boite postale</label>
                                <input type="text" class="form-control" name="bp" placeholder="Entrer l'adresse de la boite postale" value="{{ old('bp') }}" onkeyup="this.value=this.value.toUpperCase()">
                            </div>                            
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Adresse email <span style="color:red">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Entrer l'adresse email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="form-label">Ville de siège <span style="color:red">*</span></label>
                                <select class="form-control select2bs4 @error('ville_id') is-invalid @enderror" name="ville_id" data-placeholder="Choisissez une ville..." >
                                    <option value=""></option>
                                    @foreach($villes as $ville)
                                        <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Logo <span style="color:red">*</span></label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="form-label">Mot de passe <span style="color:red">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="******">
                            </div>
							<div class="col-md-6 mb-4">
                                <label for="" class="form-label">Confirmer le mot de passe<span style="color:red">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" id="password-confirm" placeholder="******">
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