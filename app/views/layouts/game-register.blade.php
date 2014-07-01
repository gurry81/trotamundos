<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Trotamundos</title>
	<!-- STYLES -->
	{{HTML::style("css/reset.css")}}
	{{HTML::style("css/icomoon.css")}} 
	<!--  header -->
	{{HTML::style("css/header.css")}}
	<!-- content -->
	{{HTML::style("css/single.css")}}
	{{HTML::style("css/game-register.css")}}
	<!-- footer -->
	{{HTML::style("css/footer.css")}}
	
	<!-- SCRIPTS -->
	{{HTML::script("js/jquery/jquery.js")}}
	<!-- general -->
	{{HTML::script("js/functions.js")}}
	{{HTML::script("js/param.js")}}
	<!-- header -->
	{{HTML::script("js/header.js")}}
	<!-- footer -->
	{{HTML::script("js/footer.js")}}

</head>
<body>
	@section("header")
		{{GUI::header()}}
	@show

	<div id="content">
		@yield("content")

		{{GUI::toTop()}}
	</div>

	@section("footer")
		{{GUI::footer()}}
	@show
</body>
</html>