@extends("layouts.dashboard")

@section("styles")
	@parent
	{{HTML::style("css/dash-perfil.css")}} 
@stop

@section("content")

	{{GUI::dashboard(GUI::$templates["USER-NEW"],["credentials" => Session::get("credentials"), "errors" => $errors])}}
@stop

