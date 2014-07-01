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
	{{GUI::dashboard(GUI::$templates["POST-EDIT"],["post" => $post, "errors" => $errors, "credentials" => Session::get("credentials")])}}
	{{GUI::dashboard(GUI::$templates["SPAIN-MAP"])}}
	
@stop

