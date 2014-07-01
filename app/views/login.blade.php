@extends('layouts.autentication')

@section('form')
	{{Form::open(["method" => "post","url" => "login"])}}
		<div class="form-title row">Login</div>
		<?php 
			if(count($errors->getMessages()) > 0){

				echo '<ul class="error">';
				foreach ($errors->all('<li>:message</li>') as $error) {
					echo $error;
				}
				echo '</ul>';
			} 
		?>

		<div class="row">{{Form::text('email', Session::get('credentials')["email"], array ("placeholder"=>"Email")) }}</div>
		<div class="row">{{Form::password('password',array ("placeholder"=>"Password")) }}</div>

		{{Form::submit('Logear',["class" => "btn"])}}

		<div class="row">o</div>
		<div class="row register"><a href={{route("register-form")}}>Registrate</a></div>

	{{Form::close()}}
@stop
