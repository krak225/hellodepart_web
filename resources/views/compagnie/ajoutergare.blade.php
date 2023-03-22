@extends('layouts.admin')
@section('title')
    Ajouter une gare
@endsection
@section('content')
<style>
    .bg-primary{
        height: 35px !important;
        background: orange;
        color: #fff;
        margin-top: -6px;
    }

    .tools a:hover{
      background-color: #000;
      color: #fff;
    }

    .text-red{
    	color: red;
    }
</style>
<h3 class="page-title">AJOUTER UNE GARE</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ route('home') }}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{ route('compagnie.liste.gare') }}">Gestion des gares</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="javascript::void(0)">Ajouter une gare</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Ajouter une nouvelle gare
                </div>
                <div class="tools">
                    <a href="{{ route('compagnie.liste.gare') }}" class="btn bg-primary text-white"><i class="icon-list"></i> Liste des gares</a>
                </div>
            </div>
            <div class="portlet-body form">
                <form method="POST" action="{{ route('initierPaiementCinetPay') }}" class="horizontal-form">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Désignation<sup class="text-red">*</sup></label>
                                    <input type="text" class="form-control @error('designation') is-invalid @enderror" name="nom" placeholder="Entrer la désignation">
                                    @error('nom')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Le nom est obligatoire</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Prénoms du client<sup class="text-red">*</sup></label>
                                    <input type="text" name="prenoms" class="form-control @error('prenoms') is-invalid @enderror" placeholder="Entrer le prénoms">
                                    @error('prenoms')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Le prénom est obligatoire</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Numéro de téléphone<sup class="text-red">*</sup></label>
                                    <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" placeholder="Entrer votre numéro">
                                    @error('telephone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Le numéro de téléphone est obligatoire</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Adresse email du client<sup class="text-red">Optionnel</sup></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions right">
                        <button type="submit" class="btn blue"><i class="fa fa-check-circle"></i> Enregistrer la gare</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection