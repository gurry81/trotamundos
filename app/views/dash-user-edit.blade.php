@extends("layouts.dashboard")

@section("styles")
	@parent
	{{HTML::style("css/dash-perfil.css")}} 
@stop

@section("content")
	{{GUI::dashboard(GUI::$templates["USER-EDIT"],["user" => $user, "errors" => $errors, "credentials" => Session::get("credentials")])}}
@stop

