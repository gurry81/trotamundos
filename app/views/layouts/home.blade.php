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
	<!-- sidebar -->
	{{HTML::style("css/sport-filter.css")}}
	{{HTML::style("css/other-filters.css")}}
	<!-- content -->
	{{HTML::style("css/home-list.css")}}
	<!-- footer -->
	{{HTML::style("css/footer.css")}}

	
	<!-- SCRIPTS -->
	{{HTML::script("js/jquery/jquery.js")}}
	<!-- general -->
	{{HTML::script("js/functions.js")}}
	{{HTML::script("js/param.js")}}
	<!-- header -->
	{{HTML::script("js/header.js")}}
	<!-- sidebar -->
	{{HTML::script("js/other-filters.js")}}	
	<!-- slider -->
	{{HTML::script("js/slider.js")}}
	<!-- footer -->
	{{HTML::script("js/footer.js")}}

</head>
<body>
	@section("header")
		{{GUI::header()}}
	@show

	@section("sidebar")
		<aside id="left-sidebar">
			{{GUI::sidebar(array(GUI::$templates["SPORT_FILTER"],GUI::$templates["OTHER_FILTERS"]))}}
		</aside>
	@show

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