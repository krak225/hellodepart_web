@extends('layouts.app')
@section('title')
    Message
@endsection
@section('content')
<style>
	.noempaty{
		color:red;
	}
</style>
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">Message</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="pdt80 pdbt80">
    <div class="container">
        <div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="row">
					<div class="account-info mb10">
						<div class="row">
							<div class="col-md-12 account-name">
								Echanger avec le service commercial
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mb10">
                <div class="wrap-sidebar-dashboard">
                    @include('pointvente.menu_home')
                </div>
            </div>
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			     
			</div>
        </div>
    </div>
</div> 
<div id="dialog">
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