<?php  
	Route::get('/author/{id}' ,array("as" => "author" , function($author = null){
		
		return View::make("author", ["author" => $author]);
	}));

	Route::post('/login',["as" => "login", "before" => "guest","uses" => "UserController@login"]);

	Route::get('/login',["as" => "login-form", "before" => "guest", function(){
		return View::make("login");
	}]);

	Route::get('/logout',["as" => "logout","before"=>"auth", "uses" => "UserController@logout"]);

	Route::get('/logout',["as" => "logout", "uses" => "UserController@logout"]);

	Route::post('/register',["as" => "register", "uses" => "UserController@register"]);

	Route::get('/register',["as" => "register-form", function(){
		return View::make('register');
	}]);

// Esta ruta es provisional, para realizar cambios en la base de datos
	Route::get('/update' , function(){
		$users = User::all();
		$response = [];
		foreach ($users as $user) {
			$user->password = Hash::make($user->password);
			$user->save();
			$response[] = $user->password;
		}

		return implode("<br>",$response);
	});
?>