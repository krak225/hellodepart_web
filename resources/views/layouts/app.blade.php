<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="mardanto">
    <meta name="google-site-verification" content="y1scjlPjnMwn167QNwtbzqpA3VxqGrb4rx3XU9rOoIY" />

    <title>@yield('title') | {{ config('app.name') }}</title>	
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootsnav.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link href="{{ asset('css/krakpopup.css') }}" rel="stylesheet" type="text/css"/>
	
    <!-- Color -->
    <link rel="stylesheet" type="text/css" id="skin"  href="{{ asset('assets/css/themes/default.css') }}">
    <!-- google font  -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i%7COpen+Sans:300,300i,400,400i,600,600i,700,800" >     
	
	<style>
	.top-header .wrap-top-information ul li a .box-button:hover{
		color:white;
		font-weight:bold;
	}
	
	.button-theme:hover{
		border:1px solid green;
	}
	</style>
</head>
<body>
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="wrap-top-information">
                        <ul class="list-inline left">
                            <li><a href="#"><i class="fa fa-phone"></i><span>Téléphone: (+225) 05 46 044 961 </span></a></li> 
                            <!--li><a href="#"><i class="fa fa-envelope"></i><span>Email: sales@hellodepart.com </span></a></li-->
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="wrap-top-information">
                        <ul class="list-inline right">
                            <li><a href="{{ route('register.distributeur') }}"><i class="fa fa-question-circle"></i><span>Devenir distributeur agréé</span></a></li>
						</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-default navbar-sticky white bootsnav">
        <div class="container">
            <div class="attr-nav">
                <div class="social hidden-xs hidden-sm">
                    <ul>
                        <li>
                            <a class="social-facebook" data-original-title="Facebook" data-placement="bottom" data-toggle="tooltip" href="#" title="">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a class="social-twitter" data-original-title="Twitter" data-placement="bottom" data-toggle="tooltip" href="#" title="">
                                <i class="fa-brands fa-square-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a class="social-linkedin" data-original-title="Linkedin" data-placement="bottom" data-toggle="tooltip" href="#" title="">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </li>
                        <li>
                            <a href="mailto::sales@hellodepart.com" class="social-google" data-original-title="Gmail" data-placement="bottom" data-toggle="tooltip">
                                <i class="fa-brands fa-google-plus-g"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-header">
                <button class="navbar-toggle" data-target="#navbar-menu" data-toggle="collapse" type="button">
                    <i class="fa fa-bars">
                    </i>
                </button>
                <a class="navbar-brand" href="{{ route('accueil') }}">
                    <img src="{{ asset('assets/images/hellodepart-logo.png') }}" class="logo" alt="">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav text-uppercase navbar-left" data-in="fadeInDown" data-out="fadeOutUp">
                    <li class="{{Request::is('/' ,'accueil', 'resultat-de-la-recherche','depart-du-jour') ? 'active' : ''}}">
                        <a href="{{ route('accueil') }}">
                            Accueil
                        </a>
                    </li>
                    <li class="{{Request::is('consulter-ma-reservation','ma-reservation') ? 'active' : ''}}">
                        <a href="{{ route('consulter.reservation') }}">
                            Consulter ma réservation
                        </a>
                    </li>
                    <li class="dropdown {{Request::is('devenir-distributeur-agree','notre-entreprise','creer-un-compte-distributeur') ? 'active' : ''}}">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript::void(0)">
                            Infos pratiques
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="" class="{{Request::is('') ? 'sous-active' : ''}}">
                                    Annuler mon Ticket
                                </a>
                            </li>
                            <li>
                                <a href="" class="{{Request::is('') ? 'sous-active' : ''}}">
                                    Préparer mon voyage
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register.distributeur') }}" class="{{Request::is('devenir-distributeur-agree','creer-un-compte-distributeur') ? 'sous-active' : ''}}">
                                    Devenir distributeur
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('apropos') }}" class="{{Request::is('notre-entreprise') ? 'sous-active' : ''}}">
                                    Notre entreprise
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{Request::is('nous-contactez') ? 'active' : ''}}">
                        <a href="{{ route('contact') }}">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="clearfix">
    </div>

    @yield('content')

    <footer id="footer">
        <div class="container">
            <div class="footer-one">
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <div class="footer-logo">
                             <img src="{{ asset('assets/images/clemira-logo.png') }}" alt="">
                        </div>
                        <p>
                            <span class="copyright text-uppercase">HELLODEPART</span> vous propose à travers notre guichet unique de voyage de retrouver votre destination préférée, depuis notre base de données des meilleures compagnies de transport de la place.
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <h4>
                            Navigation
                        </h4>
                        <ul class="col-md-6 menu hide-bullets nopadding">
                            <li>
                                <a href="{{ route('accueil') }}">
                                   Accueil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}">
                                    Nous Contactez
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}">
                                    Préparer mon voyage
                                </a>
                            </li>
                        </ul>
                        <ul class="col-md-6 menu hide-bullets nopadding">
                            <li>
                                <a href="">
                                   Annuler mon ticket
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register.distributeur') }}">
                                    Dévenir distibuteur
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('apropos') }}">
                                    Notre Entreprise
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <h4>
                            ABONNEZ-VOUS
                        </h4>
						<div class="wrap-newsletter">
							<p>
								Obtenir des informations de voyage sur notre site
							</p>
							@include('newsletter')
						</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-two">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="text-center">
                            Copyright © @php echo(date("Y")); @endphp
                            —
                            <a class="copyright" href="#">
                                HELLODEPART
                            </a>
                            | Tous droits réservés.
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </footer>
    
    <!-- START JAVASCRIPT -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/shuffleLetters.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/owl.caraousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootsnav.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/range-Slider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
    
	<script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/hellodepart.js') }}"></script>
    <script src="{{ asset('js/jquery.krakpopup.js') }}"></script>

    <!-- Custom  js-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!-- End JAVASCRIPT -->
    <script>
		@if(Session::has('info_succes'))
			toastr.success("{{ Session::get('info_succes') }}", 'SUCCÈS')
		@endif

        @if(Session::has('info_error'))
            toastr.error("{{ Session::get('info_error') }}", 'ERREUR')
        @endif

        @if(Session::has('info_warning'))
            toastr.warning("{{ Session::get('info_warning') }}", 'ERREUR')
        @endif
	</script>
</body>
</html>
