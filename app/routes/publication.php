<?php 
	Route::get('/route' ,array("as" => "route" , function(){
		return View::make("routes");
	}));

	Route::get('/route/single' ,array("as" => "singleroute" , function(){
		return View::make("events");
	}));

	Route::match(["GET","POST"],'/post/vote/{id}' ,array("as" => "vote", "uses" => "PublicationController@vote"));

	Route::post('/post/delete-vote/{id}' ,array("as" => "delete-vote", "uses" => "PublicationController@deleteVote"));


 ?>