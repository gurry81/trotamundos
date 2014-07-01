@extends("layouts.dashboard")

@section("styles")
	@parent
	{{HTML::style("css/dash-post.css")}} 
@stop

@section("scripts")
	@parent
	{{HTML::script("js/ckeditor/ckeditor.js")}} 
	{{HTML::script("js/dash-post.js")}} 
@stop

@section("content")

	{{GUI::dashboard(GUI::$templates["GAME-NEW"],["credentials" => Session::get("credentials"), "errors" => $errors])}}
	{{GUI::dashboard(GUI::$templates["SPAIN-MAP"])}}
@stop