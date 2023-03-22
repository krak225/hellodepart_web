<style>
	.tabbable{
		font-size:16px !important;
	}
	
	.badge-success{
		background-color:green;
	}
	
	.badge-warning{
		background-color:orange;
	}
	
	.badge-primary{
		background-color:blue;
	}
	
	.badge-danger{
		background-color:red;
	}
</style>
<div class="tabbable tabbable-tabdrop" style="margin-top:-25px">
	<ul class="nav nav-tabs text-uppercase" style="font-weight: bold;">
		<li class="active">
			<a href="#tab1" data-toggle="tab">Informations générales</a>
		</li>
		<li>
			<a href="#tab2" data-toggle="tab">Informations Client</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1" style="background-color: #FFF; padding: 10px; font-size: 16px;">
			<p>
				<div class="row">
					<div class="col-md-6">
						<p><span style="font-weight:bold">Référence :</span> {{ $facture->facture_numero }}</p>
						<p><span style="font-weight:bold">Gain :</span> {{ number_format($facture->facture_partpdv, 0, ',', ' ') }}  FCFA</p>
						<p><span style="font-weight:bold">Solde Facture :</span> {{ number_format($facture->facture_montant, 0, ',', ' ') }} FCFA</p>
					</div>
					<div class="col-md-6">
						<p><span style="font-weight:bold">Destination :</span> {{ $destination->ligne_designation }}</p>
						<p><span style="font-weight:bold">Date de création :</span> {{ \Carbon\Carbon::parse($facture->facture_date_creation)->format('d-m-Y')}}</p>
						<p><span style="font-weight:bold">Statut :</span>
							@if($facture->facture_statut_paiement == 'PAYE')
                                <span class="badge badge-success">Payée</span>
                            @elseif($facture->facture_statut_paiement == 'BROUILLON')
                                <span class="badge badge-warning">En cours</span>
                            @elseif($facture->facture_statut_paiement == 'ANNULE')
                                <span class="badge badge-danger">Annulé</span>
                            @elseif($facture->facture_statut_paiement == 'IMPAYE')
                                <span class="badge badge-danger">Impayée</span>
                            @endif
						</p>
					</div>
				</div>
			</p>
		</div>
		<div class="tab-pane" id="tab2" style="background-color: #FFF; padding: 10px;">
			<p style="font-size: 16px !important; text-align: center;">
				<div class="row">
					<div class="col-md-6">
						<p><span style="font-weight:bold">Nom & Prénoms :</span> {{ $client->client_nom }} {{ $client->client_prenoms }}</p>
						<p><span style="font-weight:bold">Numéro d'embarquement :</span> <span style="color:green; font-weight:bold">{{ $client->client_code }}</span></p>
					</div>
					<div class="col-md-6">
						<p><span style="font-weight:bold">Téléphone :</span> +225 {{ $client->client_telephone }}</p>
						@if($client->client_email !=null)<p><span style="font-weight:bold">Adresse Email :</span> {{ $client->client_email }}</p>@endif
					</div>
				</div>
			</p>
		</div>
	</div>
</div>
