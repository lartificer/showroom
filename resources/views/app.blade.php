<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
	<title>Lartificer</title>

	<link href="{{ asset('/css/libs/normalize.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/libs/foundation.min.css') }}" rel="stylesheet">
    @yield('styles')

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="top-bar" data-topbar role="navigation">
		<ul class="title-area">
			<li class="name">
				<h1><a href="/">Lartificer</a></h1>
			</li>
			<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
			<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
		</ul>

		<section class="top-bar-section">
			<!-- Left Nav Section -->
			<ul class="left">
				<li><a href="{{ trans("contactform::links.contact") }}">Contact</a></li>
                <li><a href="{{ trans("news::links.overview") }}">News</a></li>
			</ul>
            @if(Auth::check())
                <ul class="right" style="color: #ffffff;">
                    <li>Hi, {{ Auth::user()->name }}</li>
                    <li><a href="/logout">Logout</a></li>
                </ul>
            @endif
		</section>
	</nav>

	@yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    @yield('scripts')
	
</body>
</html>
