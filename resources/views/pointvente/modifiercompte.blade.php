@extends('layouts.index')
@section('title')
    Modifier mon compte
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Modifier mon compte</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Mon compte</li>
                        <li class="breadcrumb-item">Modification de mes paramètres</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Modifier mon compte</h3>
                </div>
                <form action="{{ route('save.modifier.compte') }}" method="POST">
                    @csrf
                    <div class="card-body">                           
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="form-label">Nom <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" placeholder="Entrer votre nom" value="{{ Auth::user()->nom }}"  onkeyup="this.value=this.value.toUpperCase()">
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Le nom est obligatoire</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="form-label">Prénoms <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('prenoms') is-invalid @enderror" name="prenoms" placeholder="Entrer votre prénoms" value="{{ Auth::user()->prenoms }}"  onkeyup="this.value=this.value.toUpperCase()">
                                @error('prenoms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Le prénoms est obligatoire</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row" style="margin-top:16px">
                            <div class="col-sm-4">
                                <label for="" class="form-label">Ville <span style="color:red">*</span></label>
                                <select class="form-control select2bs4" name="ville_id" data-placeholder="Choisissez une ville..." >
                                    <option value=""></option>
                                    @foreach($villes as $ville)
                                        <option @if(Auth::user()->ville_id == $ville->ville_id) selected @endif value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                    @endforeach
                                </select>
                                @error('ville_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>La ville est obligatoire</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="" class="form-label">Situation Géograhique <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" placeholder="Entrer votre situation géographique" value="{{ Auth::user()->adresse_geo }}" >
                                @error('adresse')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>La situation géographique est obligatoire</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="" class="form-label">Numéro de téléphone <span style="color:red">*</span></label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" placeholder="+225 XXX XXX XXXX" value="{{ Auth::user()->telephone }}"  onkeypress="isInputNumber(event)">
                                @error('telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>La situation géographique est obligatoire</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Mise à jour du compte</button>
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
@endsection