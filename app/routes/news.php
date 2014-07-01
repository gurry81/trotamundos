<?php 
	Route::get('/post' ,array("as" => "post" , function(){
		return View::make("news");
	}));

	Route::get('/post/single/{id}' ,array("as" => "singlepost" , function($id){
		$options = ["type" => Publication::$type['NEW']];
		$options["id"] = $id;

		$query = new Query($options);
		$post = Publication::getPublication($query->options);

		if($post)
			return View::make("single-post", ["post" => $post]);
		else
			return View::make("error")->with("error" ,["title" => trans("messages.post-not-found"), "info" => trans("messages.post-not-found-info")]);
	}));

 ?>