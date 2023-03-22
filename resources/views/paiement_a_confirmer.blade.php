@extends('layouts.app')

@section('content')
<ul class="breadcrumb no-border no-radius b-b b-light pull-in"> 
	<li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Accueil</a></li> 
	<li class="active">Paiement à approuver</li> 
</ul> 

<div class="m-b-md"> 
	<h3 class="m-b-none">Paiement à approuver</h3> 
</div>

@if(Session::has('message'))
	<div class="alert alert-success">
	  {{Session::get('message')}}
	</div>
@endif

@if(Session::has('warning'))
	<div class="alert alert-warning">
	  {{Session::get('warning')}}
	</div>
@endif

@if (Session::has('errors'))
	<div class="alert alert-danger">
		Veuillez renseigner correctement le formulaire
	</div>
@endif

@if(!empty($x_reference_id))
<script>
<!--
setTimeout(function() { window.location=window.location;}, 10000);
-->
</script>
@endif


<section class="panel panel-default"> 
	<header class="panel-heading"> 
		<div class="label-default" style="color:white;font-size: 15px;padding:7px;border-radius:4px;">Demande de paiement à confirmer</div>
	</header> 
	
	<div class="col-md-12" style="margin:0px;display:none;">
		
		<div class="actions pull-left bold" style="text-align:center;"> 
			<div class="label-default" style="color:white;font-size: 15px;padding:7px;border-radius:4px;">Demande de paiement à confirmer</div>
		</div> 
		
	</div>
	
	<div class="col-md-12" style="margin:0px;">
		
		<div class="col-md-12" > 
			<h2 style="color:#ffae00;text-align:center;">Vous avez une demande de paiement de <b>{{$montant}} FCFA</b> à confirmer</h2>
			
			<div class="col-md-12" style="padding:7px;border-radius:4px;font-weight:bold;font-size:24px;text-align:center;">
				Veuillez composer *133# pour approuver le paiement
			</div>
			
		</div> 
		
	</div>
	
	<br style="clear:both;"/>	
	
</section>


</div>
 
@endsection