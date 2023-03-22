@extends('layouts.index')
@section('title')
    Rerserver un ticket
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rerserver un ticket</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Gestion des tickets</li>
                        <li class="breadcrumb-item">Rerserver un ticket</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Rechercher un départ</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <!--button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button-->
                    </div>
                </div>
                <form action="{{ route('pointvente.resultat.recherche') }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>D'où partez-vous ?</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="v">
                                        <option selected="selected" value="">Choisissez une ville de départ</option>
                                        @foreach($villes as $ville)
                                            <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                        @endforeach
                                    </select>
                                    @error('v')
                                        <p style="color:red">Ville de départ obligatoire !</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Où allez-vous ?</label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="d">
                                        <option selected="selected" value="">Choisissez une ville de destination</option>
                                        @foreach($villes as $ville)
                                            <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                        @endforeach  
                                    </select>
                                    @error('d')
                                        <p style="color:red">Ville de destination obligatoire !</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date de départ</label>
                                    <input class="form-control input-lg" name="dt" min="<?php echo gmdate('Y-m-d'); ?>" type="date" value="{{ old('dt') }}">                                            
                                    @error('dt')
                                        <p style="color:red">Date de départ obligatoire !</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection