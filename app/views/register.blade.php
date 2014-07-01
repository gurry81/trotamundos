@extends('layouts.autentication')

@section('form')
	{{Form::open(["method" => "post","url" => "register", "files" => true])}}
		<h2 class="form-title">Register Form</h2>
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
		<div class="row">{{Form::text('nick',Session::get('credentials')["nick"],array ("placeholder"=>"Nick","maxlength" => "20")) }}</div>
		<div class="row">{{Form::password('password',array ("placeholder"=>"Password")) }}</div>
		<div class="row">{{Form::password('password_confirmation',array ("placeholder"=>"Repeat Password")) }}</div>
		<div class="row">{{Form::file('image', array("accept" => "image/*")) }}</div>

		{{Form::submit('Registrarse',["class" => "btn"])}}
	{{Form::close()}}
@stop
