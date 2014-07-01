<?php 
	// fitler language
	Route::when('*', 'lang',array('get',"post"));

	Route::get('/' ,array("as" => "home" , function(){
		return View::make("index");
	}));

	Route::get('/slider/post',array("as" => "post-slider" , "uses" => "PublicationController@getSliderPublications"));

	Route::get('/slider/game',array("as" => "game-slider" , "uses" => "PublicationController@getSliderPublications"));

	Route::get('/help',array("as" => "help" , "uses" => "HomeController@help"));
 ?>