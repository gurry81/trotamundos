<?php 
	App::missing(function($exception){

		return $exception;
	});

	// App::error(function(InvalidUserException $exception){
	// 	return $exception;
	// });
	
 ?>