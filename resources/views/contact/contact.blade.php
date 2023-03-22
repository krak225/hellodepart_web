@extends('layouts.app')
@section('title')
	Nous contactez
@endsection
@section('content')
<style>
	form p{
		color:red
	}
</style>
<script src="https://www.google.com/recaptcha/api.js"></script>
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">Nous contactez</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container pdt80 pdbt80">
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7">
			<div class="contact-us">
				<h3>
					Laisser un message
				</h3>
				<div class="row">
					<form action="{{ route('envoiemail') }}" method="POST" role="form">
						@csrf
						<div class="col-xs-4 col-sm-4 col-md-4">
							<div class="form-group">
								<input class="form-control input-lg" value="{{ old('nom') }}" name="nom" placeholder="Votre nom" type="text" required>
								@error('nom')
									<p>Entrer votre nom !</p>
								@enderror
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4">
							<div class="form-group">
								<input class="form-control input-lg" value="{{ old('prenoms') }}" name="prenoms" placeholder="Votre prénoms" type="text" required>
								@error('prenoms')
									<p>Entrer votre prénoms !</p>
								@enderror
							</div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4">
							<div class="form-group">
								<input class="form-control input-lg" value="{{ old('email') }}" name="email" placeholder="Votre email" type="email" required>
								@error('email')
									<p>Entrer votre email !</p>
								@enderror
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<textarea name="message" class="form-control" value="" cols="40" rows="8" aria-invalid="false" required placeholder="Entrer un message">{{ old('message') }}</textarea>
								@error('message')
									<p>Entrer un message !</p>
								@enderror
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<div class="g-recaptcha" data-sitekey="6Lf40M0iAAAAALoC9aZoL1VqKMJRc05WinNnigKm"></div>
							</div>
							<button class="btn button-theme btn-lg" href="#" type="submit">
								Envoyer le message
								<i class="fa fa-long-arrow-right">
								</i>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-5 col-md-5">
			<div class="contact-information">
				<h3>
					Informations générales
				</h3>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="info-location">
					<span>
						<i class="fa fa-map">
						</i>
						Riviera Faya, près de l'Église Catholique Saint Paul des Lauriers
					</span>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="info-location">
					<i class="fa fa-envelope">
					</i>
					<span>
						sales@hellodepart.com
					</span>
				</div>
			</div>
			<!--div class="col-xs-12 col-sm-12 col-md-12">
				<div class="info-location">
					<span>
						<i class="fa fa-mobile">
						</i>
						(+225) 05 46 044 961
					</span>
				</div>
			</div-->
		</div>
	</div>
</div>
@endsection