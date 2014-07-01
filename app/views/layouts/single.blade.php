<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Trotamundos</title>
	@section("styles")
	<!-- STYLES -->
	{{HTML::style("css/reset.css")}}
	{{HTML::style("css/icomoon.css")}} 
	<!--  header -->
	{{HTML::style("css/header.css")}}
	<!-- sidebar -->
	{{HTML::style("css/single-sidebar.css")}}
	<!-- content -->
	{{HTML::style("css/single.css")}}
	<!-- footer -->
	{{HTML::style("css/footer.css")}}
	@show
	
	<!-- SCRIPTS -->
	{{HTML::script("js/jquery/jquery.js")}}
	<!-- general -->
	{{HTML::script("js/functions.js")}}
	{{HTML::script("js/param.js")}}
	<!-- header -->
	{{HTML::script("js/header.js")}}
	<!-- content -->
	{{HTML::script("js/single.js")}}
	<!-- footer -->
	{{HTML::script("js/footer.js")}}

</head>
<body>
	@section("header")
		{{GUI::header()}}
	@show

	<aside id="left-sidebar">
		@yield("sidebar")
	</aside>

	<div id="content">
		@yield("content")

		{{GUI::toTop()}}
		{{GUI::help()}}
	</div>

	@section("footer")
		{{GUI::footer()}}
	@show
</body>
</html>