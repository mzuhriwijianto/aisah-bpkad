<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ LAConfigs::getByKey('site_description') }}">
    <meta name="author" content="Dwij IT Solutions">

    <meta property="og:title" content="{{ LAConfigs::getByKey('sitename') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ LAConfigs::getByKey('site_description') }}" />

    <meta property="og:url" content="http://laraadmin.com/" />
    <meta property="og:sitename" content="laraAdmin" />
	<meta property="og:image" content="http://demo.adminlte.acacha.org/img/LaraAdmin-600x600.jpg" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@laraadmin" />
    <meta name="twitter:creator" content="@laraadmin" />

    <title>{{ LAConfigs::getByKey('sitename') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/la-assets/css/bootstrap.css') }}" rel="stylesheet">

	<link href="{{ asset('la-assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('/la-assets/css/main.css') }}" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    <script src="{{ asset('/la-assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('/la-assets/js/smoothscroll.js') }}"></script>


</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">

<!-- Fixed navbar -->
<div id="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><b>{{ LAConfigs::getByKey('sitename') }}</b></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <!--<li><a href="{{ url('/register') }}">Register</a></li>-->
                @else
                    <li><a href="{{ url(config('laraadmin.adminRoute')) }}">{{ Auth::user()->name }}</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>


<section id="home" name="home"></section>
<div id="headerwrap">
    <div class="container">
        <div class="row centered">
            <div class="col-lg-12">
                <h1>{{ LAConfigs::getByKey('sitename_part1') }} <b><a>{{ LAConfigs::getByKey('sitename_part2') }}</a></b></h1>
                <h3>{{ LAConfigs::getByKey('site_description') }}</h3>
                <h3><a href="{{ url('/admin') }}" class="btn btn-lg btn-success">Masuk</a></h3><br>
            </div>
            <!--<div class="col-lg-12">
                <img class="img-responsive" src="{{ asset('/la-assets/img/app-bg.jpg') }}" alt="">
            </div>-->
        </div>
    </div> <!--/ .container -->
</div><!--/ #headerwrap -->


<section id="about" name="about"></section>
<!-- INTRO WRAP -->
<div id="intro">
    <div class="container">
        <div class="row centered">
            <div class="col-lg-3">
                <i class="fa fa-map" style="font-size:100px;height:110px;"></i>
                <h3>Tanah</h3>
                <p>Location Coordinate & Documentation.</p>
            </div>
            <div class="col-lg-3">
                <i class="fa fa-car" style="font-size:100px;height:110px;"></i>
                <h3>Kendaraan</h3>
                <p>Documentation</p>
            </div>
            <div class="col-lg-3">
                <i class="fa fa-building" style="font-size:100px;height:110px;"></i>
                <h3>Gedung & Bangunan</h3>
                <p>Location</p>
            </div>
			<div class="col-lg-3">
                <i class="fa fa-road" style="font-size:100px;height:110px;"></i>
                <h3>Jalan & Jaringan</h3>
                <p>Projection</p>
            </div>
        </div>
        <br>
        <hr>
    </div> <!--/ .container -->
</div><!--/ #introwrap -->

<section id="contact" name="contact"></section>
<div id="footerwrap">
    <div class="container">
        <div class="col-lg-12 rightpane">
            <h3>Contact Us</h3><br>
            <p>
				Bidang Pengelolaan Aset Daerah,<br/>
				Badan Pengelolaan Keuangan dan Aset Daerah<br/>
                Kabupaten Bojonegoro,<br/>
                jL. P Mastumapel No. 1 Bojonegoro<br/>
                Kabupaten Bojonegoro, Jawa Timur 62111 Indonesia
            </p>
			<div class="contact-link"><i class="fa fa-envelope-o"></i> <a href="#">bpkad.bojonegorokab.go.id</a></div>
			<div class="contact-link"><i class="fa fa-cube"></i> <a href="#">aisah.bpkad.id</a></div>
        </div>
    </div>
</div>
<div id="c">
    <div class="container">
        <p>
            <strong>Copyleft &copy; 2022. Powered by <a href="#"><b>BPKAD BOJONEGORO</b></a>
        </p>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('/la-assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })
</script>
</body>
</html>
