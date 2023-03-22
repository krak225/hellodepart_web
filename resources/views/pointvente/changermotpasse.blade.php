@extends('layouts.index')
@section('title')
    Changer son mot de passe
@endsection
@section('content')
<style>
	.noempaty{
		color:red;
	}
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Changer son mot de passe</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
                        <li class="breadcrumb-item">Mon compte</li>
                        <li class="breadcrumb-item">Changer le mot de passe</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Changer son mot de passe</h3>
                </div>
                <form action="{{ route('save.change.motpasse') }}" method="POST">
                    @csrf
                    <div class="card-body">                           
                        <div class="row" style="margin-top:16px">
							<div class="col-sm-4">
								<label for="current_password" class="form-label">Mot de passe actuel <span class="noempaty">*</span></label>
								<input type="password" class="form-control" id="current_password" name="current_password">
							</div>
							<div class="col-sm-4">
								<label for="new_password" class="form-label">Nouveau mot de passe <span class="noempaty">*</span></label>
								<input type="password" class="form-control" id="new_password" name="new_password">
							</div>
							<div class="col-sm-4">
								<label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe <span class="noempaty">*</span></label>
								<input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
							</div>
						</div>
						<div class="row" style="margin-top:16px">
							
						</div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Changer le mot de passe</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div> 
@endsection