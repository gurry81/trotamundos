<?php 
	Route::get('/game' ,array("as" => "game" , function(){
		return View::make("events");
	}));

	Route::get('/game/single/{id}' ,array("as" => "singlegame" , function($id){
		$options = ["type" => Publication::$type['EVENT']];
		$options["id"] = $id;

		$query = new Query($options);
		$post = Publication::getPublication($query->options);

		if($post)
			return View::make("single-game", ["post" => $post]);
		else
			return View::make("error")->with("error" ,["title" => trans("messages.post-not-found"), "info" => trans("messages.post-not-found-info")]);
	}));

	Route::match(["GET","POST"],'/game/register' ,array("as" => "game-register" , "uses" => "GameController@pagoPaypal"));

	Route::get('/game/register/{event}' ,array("as" => "game-info", function($event){
		$game = Game::with("player")
				->where("id", "=", $event)
				->get();
		if(count($game))
			return View::make("game-register")->with("event",$game[0]);

		return View::make("error")->with("error" ,["title" => trans("messages.post-not-found"), "info" => trans("messages.post-not-found-info")]);
	}));

	Route::match(["GET","POST"],'/game/register-user/{event}' ,array( "uses" => "GameController@register"));

 ?>