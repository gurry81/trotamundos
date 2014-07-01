<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Trotamundos</title>
	<!-- STYLES -->
	{{HTML::style('css/reset.css')}}
	{{HTML::style('css/icomoon.css')}}
	{{HTML::style('css/autentication.css')}}
	<!-- SCRIPTS -->
	{{HTML::script('js/param.js')}}
	{{HTML::script('js/autentication.js')}}
</head>
<body>
	<div id="title"><a href=<?php echo route("home") ?>>TROTAMUND<span class="icon-earth"></span>S</a></div>
	@section('language')
		<select id="language" onchange="changeLocale(this.value)">
			<option value = "es" <?php echo (App::getLocale() == "es")? "selected" : "" ?>>Español</option>
			<option value = "en" <?php echo (App::getLocale() == "en")? "selected" : "" ?>>English</option>
		</select>
	@show

	@yield('form')	
</body>
</html>

