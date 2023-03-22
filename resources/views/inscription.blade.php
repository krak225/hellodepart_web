@extends('layouts.app')
@section('title')
	Devenir un distributeur agréé
@endsection
@section('content')
<style>
	.invalid-feedback{
		color:red;
        font-style: italic;
	}
</style>
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">Devenir un distributeur agréé</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="wrap-recent-property pdt40 pdbt80 wow fadeInUp delay-08s">
    <div class="container">
        <div class="row">
            <h3 class="text-center" style="margin-left: 12px;">Comment devenir distributeur agréé HelloDepart?</h3>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <h4>Développez votre business grâce à…</h4>
                <p><strong>Une source de revenus supplémentaires</strong></p>
                <p>Enrichissez votre gamme de services et votre base de clients pour générer de nouveaux revenus pour votre entreprise.</p>
                <br>
                <p><strong>Une opportunité de partenariat Business to business (B2B)</strong></p>
                <p>Avec HelloDepart, bénéficiez d’une nouvelle opportunité commerciale, et augmentez davantage votre chiffre d’affaires grâce à nos activités de réservation de tickets à distance.</p>
                <br>
                <p><strong>Une Assistance 24/7</strong></p>
                <p>Recevez l’assistance technique dont vous et vos clients avez besoin pour poursuivre le développement de votre activité et de votre cœur de métier.</p>
                <br>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="profile-img wow fadeInRight delay-07s">
                    <img class="img-responsive" src="{{ asset('assets/images/distributeur.png') }}"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <p><strong>Inscrivez-vous et enregistrez dès aujourd'hui votre point de vente</strong></p>
                <p>HelloDepart propose à ses Points de vente une plate-forme de marketing et de business basé sur un système de billetterie innovant.</p>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<!--div class="bg-default pdt80 pdbt80">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="{{ route('register') }}" class="form-horizontal" method="POST" role="form">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Nom <span style="color:red">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" placeholder="Entrer votre nom" value="{{ old('nom') }}" required>
                            @error('nom')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Le nom est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Prénoms <span style="color:red">*</span></label>
                            <input type="text" class="form-control @error('prenoms') is-invalid @enderror" name="prenoms" placeholder="Entrer votre prénoms" value="{{ old('prenoms') }}" required>
                            @error('prenoms')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Le prénoms est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row" style="margin-top:16px">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Ville <span style="color:red">*</span></label>
                            <select class="form-control chosen-select" name="ville_id" data-placeholder="Choisissez une ville..." required>
                                <option value=""></option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->ville_id }}">{{ $ville->ville_libelle }}</option>
                                @endforeach
                            </select>
                            @error('ville_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>La ville est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Situation Géograhique <span style="color:red">*</span></label>
                            <input type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" placeholder="Entrer votre situation géographique" value="{{ old('adresse') }}" required>
                            @error('adresse')
                                <span class="invalid-feedback" role="alert">
                                    <strong>La situation géographique est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row" style="margin-top:16px">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Numéro de téléphone <span style="color:red">*</span></label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" placeholder="+225 XXX XXX XXXX" value="{{ old('telephone') }}" required>
                            @error('telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>La situation géographique est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Adresse Email <span style="color:red">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Entrer votre adresse email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>L'adresse email est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row" style="margin-top:16px">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Mot de passe <span style="color:red">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="*********">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Le mot de passe est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Confirmer mot de passe <span style="color:red">*</span></label>
                            <input type="password" id="password-confirm" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="*********" name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>La confirmation est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <center style="margin-top:16px">
                       <button class="btn button-md button-theme" type="submit">Créer mon compte
                    </button>
                </form>
           </div>
        </div>
    </div>
</div-->
@endsection