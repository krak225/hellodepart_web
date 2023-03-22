@extends('layouts.app')
@section('title')
	À propos de nous
@endsection
@section('content')
<style>
	form p{
		color:red
	}
</style>
<div class="member-header-footer ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('accueil') }}">Home</a></li>
                    <li class="active">À propos de nous</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<section class="about-us margin-top-30">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="profile wow fadeInRight delay-07s">
                    <h3><span>À propos de nous</span></h3>
                    <p>
                       Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus corporis ea provident numquam reiciendis laudantium eligendi pariatur. Molestiae ipsum aliquam itaque dignissimos ratione dolor ab, voluptatum delectus necessitatibus officiis nam.
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus perspiciatis est voluptatum assumenda, qui nihil id explicabo, aspernatur libero, eligendi debitis nulla adipisci mollitia corrupti deserunt ipsum error unde quidem.
                    </p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="profile-img wow fadeInRight delay-07s">
                    <img alt="#" class="img-responsive" src="{{ asset('assets/images/apropos.jpg') }}"/>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection