@extends('layouts.index')
@section('title')
	Réserver son ticket maintenant
@endsection
@section('content')
@if(!empty($reservation))
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Réserver son ticket maintenant</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              	<li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
	            <li class="breadcrumb-item">Gestion des tickets</li>
	            <li class="breadcrumb-item">Réserver un ticket</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
      	@if(Session::has('warning'))
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
			  	<strong>Information : </strong> {{Session::get('warning')}}
			  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    	<span aria-hidden="true">&times;</span>
			  	</button>
			</div>
		@endif
      	<form method="POST" action="{{ route('initierPaiementCinetPay') }}">
			@csrf
			<input type="hidden" name="montant" value="{{ $reservation->depart_tarif }}">	
			<input type="hidden" name="frais" value="{{ $reservation->depart_frais }}">	
			<input type="hidden" name="timbre" value="{{ $reservation->depart_timbre_etat }}">	
			<input type="hidden" name="depart_id" value="{{ $reservation->depart_id }}">	
			<input type="hidden" name="date_depart" value="{{ $reservation->depart_date_arrivee }}">	
			<input type="hidden" name="heure_depart" value="{{ $reservation->depart_heure_arrivee }}">	
	        <div class="row">
	          <div class="col-md-6">
	            <div class="card card-primary">
	              <div class="card-header">
	                <h3 class="card-title">Information sur la réservation</h3>
	              </div>
	              <div class="card-body">
	              	<div class="row">
	              		<div class="col-md-4">
			                <div class="form-group">
			                  	<label>Date de départ</label>
			                  	<div class="input-group">
			                    	<input class="form-control @error('date_depart') is-invalid @enderror" name="date_depart" value="{{ \Carbon\Carbon::parse($reservation->depart_date_arrivee)->format('d-m-Y') }}" type="text" required disabled>
			                  	</div>
			                </div>
		             	</div>
		             	<div class="col-md-4">
			                <div class="form-group">
			                  	<label>Heure de depart</label>
			                  	<div class="input-group">
			                    	<input class="form-control @error('heure_depart') is-invalid @enderror" name="heure_depart" value="{{ \Carbon\Carbon::parse($reservation->depart_heure_arrivee)->format('H:i') }}" type="text" required disabled>
			                  	</div>
			                </div>
		                </div>
		                <div class="col-md-4">
			                <div class="form-group">
			                  	<label>Nombre de place</label>
			                  	<div class="input-group">
			                    	<input type="number" id="nombre_place" min="1" value="1" name="nombre_place" class="form-control" onchange="calculate()" required>
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
	                <div class="form-group">
	                  	<label>Nom du client</label>
	                  	<div class="input-group">
	                    	<input class="form-control input-lg @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" placeholder="Entrer le nom"  type="text" required onkeyup="this.value=this.value.toUpperCase()">
	                  	</div>
	                  	@error('nom')
                            <span class="invalid-feedback" role="alert">
                                <strong>Le nom est obligatoire</strong>
                            </span>
                        @enderror
	                </div>
	                <div class="form-group">
	                  	<label>Prénom du client</label>
	                  	<div class="input-group">
	                    	<input class="form-control input-lg" name="prenoms" value="{{ old('prenoms') }}" placeholder="Entrer votre prénoms"  type="text" required onkeyup="this.value=this.value.toUpperCase()">
	                  	</div>
	                  	@error('prenoms')
                            <span class="invalid-feedback" role="alert">
                                <strong>Le prénom est obligatoire</strong>
                            </span>
                        @enderror
	                </div>
	                <div class="form-group">
	                  	<label>Numéro de téléphone</label>
	                  	<div class="input-group">
	                    	<input class="form-control input-lg" name="telephone" id="numero" value="{{ old('telephone') }}" placeholder="Entrer votre numéro / WhatsApp"  type="text" required onkeypress="isInputNumber(event)">
	                  	</div>
	                  	@error('telephone')
                            <span class="invalid-feedback" role="alert">
                                <strong>Le numéro de téléphone est obligatoire</strong>
                            </span>
                        @enderror
	                </div>
	              </div>
	            </div>
	          </div>
	          <div class="col-md-6">
	            <div class="card card-primary">
	              <div class="card-header">
	                <h3 class="card-title">Calcul du coût de la réservation <small style="font-style: italic;">Tous les coûts sont en FCFA</small></h3>
	              </div>
	              <div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6">
							<label>Coût Unitaire</label>
							<input type="text" id="montant" name="montant" class="form-control" value="{{ $reservation->depart_tarif }}" onchange="calculate()" readonly>
						</div>
						<div class="col-md-6">
				    		<label for="montantbrut">Montant Brut</label>
				    		<input type="text" id="montantbrut" value="{{ $reservation->depart_tarif }}" name="montantbrut" class="form-control" readonly>
				    	</div>
					</div>
	                <div class="row mb-3">				    	
				    	<div class="col-md-6">
				    		<label for="">Frais</label>
				    		<input type="hidden" class="form-control" id="valeurfrais" name="valeurfrais" value="{{ $reservation->depart_frais }}" onchange="calculate()" readonly>
				    		<input type="text" class="form-control" id="frais" name="frais" value="{{ $reservation->depart_frais }}" readonly>
				    	</div>
						<div class="col-md-6">
				    		<label for="">Timbre d'État</label>
				    		<input type="hidden" class="form-control" id="valeurtimbre" name="valeurtimbre" value="{{ $reservation->depart_timbre_etat }}" onchange="calculate()" readonly>
				    		<input type="text" class="form-control" value="{{ $reservation->depart_timbre_etat }}" readonly>
				    	</div>
				    </div>
				    <div class="row mb-3">
				    	<div class="col-md-6">
				    		<label for="montantttc">Montant Total</label>
						    @php 
								$montant = $reservation->depart_tarif + $reservation->depart_frais;
								$montant_ttc = $montant + $reservation->depart_timbre_etat;								
							@endphp
						    <input type="text" id="montantttc" name="montantttc" value="{{ $montant_ttc }}" class="form-control" readonly>
				    	</div>
						<div class="col-md-6">
							<label for="">Frais opérateur mobile</label>
							@php 
								$montant_op = $montant * $paramsfrais->paramfrais_tauxtelco_in_wave;								
							@endphp
							<input type="hidden" class="form-control" id="montant_opr" name="montant_opr" value="{{ $paramsfrais->paramfrais_tauxtelco_in_wave }}">
							<input type="text" class="form-control" id="frais_op" name="frais_op" value="{{ $montant_op }}" readonly>
						</div>
				    </div>
					<div class="row mb-3">
				    	<div class="col-md-12">
				    		<label for="montantttc">Net à Payer</label>
						    @php 
								$montant = $reservation->depart_tarif + $reservation->depart_frais;
								$montant_op = $montant * $paramsfrais->paramfrais_tauxtelco_in_wave;
								$montant_apaye = $montant + $montant_op + $reservation->depart_timbre_etat;								
							@endphp
						    <input type="text" id="montantapaye" name="montantapaye" value="{{ $montant_apaye }}" class="form-control" readonly>
				    	</div>
				    </div>
	              </div>
	                <div class="card-footer">
	                  <button class="btn btn-success btn-block">Payer maintenant</button>
	                  <!--button class="btn btn-primary btn-block">Payer maintenant</button-->
	                </div>
	            </div>
	          </div>
	        </div>
       </form>
      </div>
    </section>
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
        var valeurtimbre = document.getElementById("valeurtimbre").value;
        var valeuropr = document.getElementById("montant_opr").value;

        var montantBRUT = montant * nombre_place;        
        var montantFrais = (nombre_place * valeurfrais);        
        var montantTimbre = (valeurtimbre * 10) / 10;  
		// $montant = $reservation->depart_tarif + $reservation->depart_frais;  	    
        var montantOPR = (montantBRUT + montantFrais) * valeuropr;
        var montantTTC = montantBRUT + montantFrais + montantTimbre;
        var montantApaye = montantBRUT + montantFrais + montantTimbre + montantOPR;

        document.getElementById("montantapaye").value = montantApaye.toFixed(2);
        document.getElementById("montantttc").value = montantTTC.toFixed(2);
        document.getElementById("frais_op").value = montantOPR.toFixed(2);
	    document.getElementById("montantbrut").value = montantBRUT.toFixed(2);
	    document.getElementById("frais").value = montantFrais.toFixed(2);

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
    const telephoneInput = document.getElementById("numero");

    // Définition de la limite de saisie à une caractère
    telephoneInput.maxLength = 10;
</script>
@endsection