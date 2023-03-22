@extends('layouts.app')
@section('title')
	Réservation
@endsection
@section('content')
<style>
	.wrap-gallery{
		background: #ccc;
	}

	.wrap-gallery .reservation-row{
		background: #fff;
	}

	.float-end{
		float: right;
	}

	.invalid-feedback{
		color: red;
		font-style: italic;
		font-size: 12px;
	}
</style>
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">Réserver son ticket</li>
                </ul>
            </div>
        </div>
    </div>
</div> 
@if(!empty($reservation))
<div class="wrap-gallery clearfix">
    <div class="container">
        <div class="row wow reservation-row">
            <div class="items-container col-xs-12 wow fadeInUp delay-07s">
                <div class="item col-md-8 col-sm-8 col-xs-8">             
                    <h3 class="">Réserver un ticket</h3>
                	@guest
						<form method="POST" action="{{ route('initPaiementCinetPay') }}">
							@csrf
							<input type="hidden" name="montant" value="{{ $reservation->depart_tarif }}">	
							<input type="hidden" name="depart_id" value="{{ $reservation->depart_id }}">	
							<input type="hidden" name="date_depart" value="{{ $reservation->depart_date_arrivee }}">	
							<input type="hidden" name="heure_depart" value="{{ $reservation->depart_heure_arrivee }}">	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Date de départ</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-calendar"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg @error('date_depart') is-invalid @enderror" name="date_depart" value="{{ \Carbon\Carbon::parse($reservation->depart_date_arrivee)->format('d-m-Y') }}" type="text" required disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
		                            <div class="form-group">
		                                <label>Heure de depart</label>
		                                <div class="input-group input-group-md">
		                                    <span class="input-group-addon">
		                                        <i class="glyphicon glyphicon-time"></i>
		                                    </span>
		                                    <div class="icon-addon addon-md">
		                                        <input class="form-control input-lg @error('heure_depart') is-invalid @enderror" name="heure_depart" value="{{ \Carbon\Carbon::parse($reservation->depart_heure_arrivee)->format('H:i') }}" type="text" required disabled>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-md-4">
									<div class="form-group">
										<label>Nombre de place</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-plus-sign"></i>
											</span>
											<div class="icon-addon addon-md">
												<input type="number" id="nombre_place" min="1" value="1" name="nombre_place" class="form-control" onchange="calculate()" required>
											</div>
										</div>
				                        @error('nombre_place')
				                            <span class="invalid-feedback" role="alert">
				                                <strong>Nombre de place est obligatoire</strong>
				                            </span>
				                        @enderror
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Nom</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" placeholder="Entrer votre nom"  type="text" required onkeyup="this.value=this.value.toUpperCase()">
											</div>
										</div>
				                        @error('nom')
				                            <span class="invalid-feedback" role="alert">
				                                <strong>Le nom est obligatoire</strong>
				                            </span>
				                        @enderror
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Prénoms</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg" name="prenoms" value="{{ old('prenoms') }}" placeholder="Entrer votre prénoms"  type="text" required onkeyup="this.value=this.value.toUpperCase()">
											</div>
										</div>
				                        @error('prenoms')
				                            <span class="invalid-feedback" role="alert">
				                                <strong>Le prénom est obligatoire</strong>
				                            </span>
				                        @enderror
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Numéro de téléphone</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-phone"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg" name="telephone" value="{{ old('telephone') }}" placeholder="Entrer votre numéro / WhatsApp"  type="text" required onkeypress="isInputNumber(event)">
											</div>
										</div>
				                        @error('telephone')
				                            <span class="invalid-feedback" role="alert">
				                                <strong>Le numéro de téléphone est obligatoire</strong>
				                            </span>
				                        @enderror
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Adresse Email <sup style="color:red; font-weight: bold;">Facultatif</sup></label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-envelope"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Entrer votre email"  type="text">
											</div>
										</div>
									</div>
								</div>
							</div>
							<button class="btn button-md button-theme" type="submit">
								<i class="fa fa-user-plus"></i>
								Je réserve mon ticket
							</button><br><br>
						</form>
					@else
	                    <form method="POST" action="{{ route('initierPaiementCinetPay') }}">
							@csrf
							<input type="hidden" name="montant" value="{{ $reservation->depart_tarif }}">	
							<input type="hidden" name="depart_id" value="{{ $reservation->depart_id }}">	
							<input type="hidden" name="date_depart" value="{{ $reservation->depart_date_arrivee }}">	
							<input type="hidden" name="heure_depart" value="{{ $reservation->depart_heure_arrivee }}">	
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Date de départ</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-calendar"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg @error('date_depart') is-invalid @enderror" name="date_depart" value="{{ \Carbon\Carbon::parse($reservation->depart_date_arrivee)->format('d-m-Y') }}" type="text" required disabled>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
		                            <div class="form-group">
		                                <label>Heure de depart</label>
		                                <div class="input-group input-group-md">
		                                    <span class="input-group-addon">
		                                        <i class="glyphicon glyphicon-time"></i>
		                                    </span>
		                                    <div class="icon-addon addon-md">
		                                        <input class="form-control input-lg @error('heure_depart') is-invalid @enderror" name="heure_depart" value="{{ \Carbon\Carbon::parse($reservation->depart_heure_arrivee)->format('H:i') }}" type="text" required disabled>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-md-4">
									<div class="form-group">
										<label>Nombre de place</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-plus-sign"></i>
											</span>
											<div class="icon-addon addon-md">
												<input type="number" id="nombre_place" min="1" value="1" name="nombre_place" class="form-control" onchange="calculate()" required>
											</div>
										</div>
				                        @error('nombre_place')
				                            <span class="invalid-feedback" role="alert">
				                                <strong>Nombre de place est obligatoire</strong>
				                            </span>
				                        @enderror
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Nom</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" placeholder="Entrer votre nom"  type="text" required onkeyup="this.value=this.value.toUpperCase()">
											</div>
										</div>
				                        @error('nom')
				                            <span class="invalid-feedback" role="alert">
				                                <strong>Le nom est obligatoire</strong>
				                            </span>
				                        @enderror
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Prénoms</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg" name="prenoms" value="{{ old('prenoms') }}" placeholder="Entrer votre prénoms"  type="text" required onkeyup="this.value=this.value.toUpperCase()">
											</div>
										</div>
				                        @error('prenoms')
				                            <span class="invalid-feedback" role="alert">
				                                <strong>Le prénom est obligatoire</strong>
				                            </span>
				                        @enderror
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Numéro de téléphone</label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-phone"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg" name="telephone" value="{{ old('telephone') }}" placeholder="Entrer votre numéro / WhatsApp"  type="text" required onkeypress="isInputNumber(event)">
											</div>
										</div>
				                        @error('telephone')
				                            <span class="invalid-feedback" role="alert">
				                                <strong>Le numéro de téléphone est obligatoire</strong>
				                            </span>
				                        @enderror
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Adresse Email <sup style="color:red; font-weight: bold;">Facultatif</sup></label>
										<div class="input-group input-group-md">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-envelope"></i>
											</span>
											<div class="icon-addon addon-md">
												<input class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Entrer votre email"  type="text">
											</div>
										</div>
									</div>
								</div>
							</div>
							<button class="btn button-md button-theme" type="submit">
								<i class="fa fa-user-plus"></i>
								Je réserve mon ticket
							</button><br><br>
						</form>
					@endguest
					
                </div>   
                <div class="item col-md-4 col-sm-4 col-xs-4">             
                    <h3 class="">Informations Générales</h3>
				    <label for="montant">Coût Unitaire :</label>
				    <input type="text" id="montant" name="montant" class="form-control" value="{{ $reservation->depart_tarif }}" onchange="calculate()" readonly>
				    <br><br>
				    <div class="row">
				    	<div class="col-md-6">
				    		<label for="montantbrut">Montant Brut :</label>
				    		<input type="text" id="montantbrut" value="{{ $reservation->depart_tarif }}" name="montantbrut" class="form-control" readonly>
				    	</div>
				    	<div class="col-md-6">
				    		<label for="">Frais :</label>
				    		<input type="hidden" class="form-control" id="valeurfrais" name="valeurfrais" value="{{ $reservation->depart_frais }}" onchange="calculate()" readonly>
				    		<input type="text" class="form-control" id="frais" name="frais" value="{{ $reservation->depart_frais }}" readonly>
				    	</div>
				    </div>	
				    <br><br>			    
				    <div class="row">				    	
				    	<div class="col-md-6">
				    		<label for="">Timbre d'État :</label>
				    		<input type="text" class="form-control" value="100" readonly>
				    	</div>
				    	<div class="col-md-6">
				    		<label for="montantttc">Total à Payer :</label>
						    @php $montant_ttc = $reservation->depart_tarif + $reservation->depart_frais + 100; @endphp
						    <input type="text" id="montantttc" name="montantttc" value="{{ $montant_ttc }}" class="form-control" readonly>
				    	</div>
				    </div>
				    <input type="hidden" id="timbre" name="timbre" class="form-control" value="100" onchange="calculate()">
                </div>  
            </div>
        </div>
    </div>
</div>
@endif

<script>  
	function isInputNumber(evt){
        
        var ch = String.fromCharCode(evt.which);
        
        if(!(/[0-9]/.test(ch))){
            evt.preventDefault();
        }        
    }  
</script>

<script>
	function calculate() {

        var montant = document.getElementById("montant").value;
        var nombre_place = document.getElementById("nombre_place").value;
        var valeurfrais = document.getElementById("valeurfrais").value;
        var timbre = document.getElementById("timbre").value;

        var montantBRUT = montant * nombre_place;        
        var montantFrais = (nombre_place * valeurfrais);        
        var montantTTC = montantBRUT + montantFrais + 100;

        document.getElementById("montantttc").value = montantTTC.toFixed(2);
	    document.getElementById("montantbrut").value = montantBRUT.toFixed(2);
	    document.getElementById("frais").value = montantFrais.toFixed(2);

  	}
</script>
@endsection