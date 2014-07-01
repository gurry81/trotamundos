<?php 

	// USERS
	Route::match(["GET","POST"],'/dashboard' ,array("as" => "dashboard" ,"before" => "auth", function(){
		return View::make("dashboard");
	}));

	Route::get('/dashboard/user/list' ,array("as" => "user-list" ,"before" => "auth", function(){
		return View::make("dash-user-list");
	}));

	Route::get('/dashboard/user/players/{event}' ,array("as" => "player-list" ,"before" => "auth", function($event){
		return View::make("dash-players",["event"=>$event]);
	}));

	Route::get('/dashboard/user/new' ,array("as" => "user-new" ,"before" => "auth", function(){
		return View::make("dash-user-new");
	}));

	Route::post('/dashboard/user/new' ,array("before" => "auth", "uses" => "UserController@create"));

	Route::match(["GET","POST"],'/dashboard/user/edit/{email}' ,array("as" => "user-edit" ,"before" => "auth", function($email){
		$user = User::find($email);

		if($user)
			return View::make("dash-user-edit",["email" => $email])->with("user",$user);

		return View::make("error")->with("error" ,["title" => trans("messages.user-not-found"), "info" => Lang::get("messages.user-not-found-info",["email" => $email])]);
	}));
	
	Route::match(["GET","POST"],'/dashboard/user/remove/{email}',["as" => "user-remove", "before" => "auth","uses" => "UserController@delete"]);

	Route::post('/dashboard/user/update',["as" => "user-update","before" => "auth", "uses" => "UserController@update"]);

	// POSTS 
	Route::match(["GET","POST"],'/dashboard/post/list' ,array("as" => "post-list" ,"before" => "auth", function(){
		return View::make("dash-post-list");
	}));

	Route::get('/dashboard/post/new' ,array("as" => "post-new" ,"before" => "auth", function(){
		$type = Auth::user()->type;
		if($type == User::$type["AUTHOR"])
			return View::make("dash-post-new");
		else if($type == User::$type["VIP"])
			return View::make("dash-game-new");
		else if($type == User::$type["ADMIN"])
			return View::make("dash-post-new");
			
		return View::make("error")->with("error" ,["title" => trans("messages.access-denied"), "info" => trans("messages.access-denied-info")]);
	}));

	Route::get('/dashboard/game/new', array("as" => "game-new", "before" => "auth", function(){
		$type = Auth::user()->type;

		if($type ==  User::$type["VIP"] || $type ==  User::$type["ADMIN"])
			return View::make("dash-game-new");

		return View::make("error")->with("error" ,["title" => trans("messages.access-denied"), "info" => trans("messsages.access-denied-info")]);
	}));

	Route::post('/dashboard/post/new' ,array("before" => "auth", "uses" => "PublicationController@create"));

	Route::get('/dashboard/post/edit/{id}' ,array("as" => "post-edit" ,"before" => "auth", function($id){
		$query = new Query(["id" => $id]);
		$post = Publication::getPublication($query->options);

		if($post)
			return View::make("dash-post-edit",["id" => $id])->with("post",$post);

		return View::make("error")->with("error" ,["title" => trans("messages.post-not-found"), "info" => trans("messages.post-not-found-info")]);
	}));

	Route::get('/dashboard/post/remove/{id}',["as" => "post-remove", "before" => "auth","uses" => "PublicationController@delete"]);

	Route::post('/dashboard/post/update/{id}',["as" => "post-update","before" => "auth", "uses" => "PublicationController@update"]);
 ?>