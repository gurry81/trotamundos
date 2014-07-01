<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Trotamundos</title>
	<!-- STYLES -->
	{{HTML::style('css/reset.css')}}
	{{HTML::style('css/icomoon.css')}}
	{{HTML::style('css/error.css')}}
</head>
<body>
	<div id="title"><a href=<?php echo route("home") ?>>TROTAMUND<span class="icon-earth"></span>S</a></div>

	@yield('error')	
</body>
</html>

