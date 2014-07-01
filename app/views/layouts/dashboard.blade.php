<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Trotamundos | Dashboard</title>
	@section("styles")
		<!-- STYLES -->
		{{HTML::style("css/dashboard.css")}}
		{{HTML::style("css/icomoon.css")}} 
	@show

	@section("scripts")
		<!-- SCRIPTS -->
		{{HTML::script("js/jquery/jquery.js")}}
		<!-- general -->
		{{HTML::script("js/functions.js")}}
		{{HTML::script("js/param.js")}}
		{{HTML::script("js/dashboard.js")}}
	@show

</head>
<body>
	@section("sidebar")
		<aside id="left-sidebar">
			{{GUI::sidebar(array(GUI::$templates["DASH-SIDEBAR"]))}}
		</aside>
	@show

	<div id="content">
		@yield("content")

		{{GUI::toTop()}}
	</div>
</body>
</html>