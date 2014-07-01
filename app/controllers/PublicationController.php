<?php

class PublicationController extends BaseController {

	public function getSliderPublications(){
		$json = Input::all();
		$json["skip"] = $json["current"];
		$response = [];
		
		if($json["paginate"])
			$json["limit"]++;

		unset($json["paginate"]);

		$query = new Query($json);
		$posts = Publication::getPublications($query->options);

		$response["more"] = false;
		$response["found"] = count($posts);

		if($response["found"] == $json["limit"]){
			$response["more"] = true;
			unset($posts[--$response["found"]]);
		}

		$response["posts"] = GUI::slider($query,$posts,true);

		return Response::json($response);
	}

	public function delete($id, $redirect = true){
		PSport::where("publication","=",$id)->delete();
		PProvince::where("publication","=",$id)->delete();
		$publication = Publication::find($id);

		switch ($publication->type) {
			case Publication::$type["NEW"]:
				$post = Post::find($id);
				unlink(public_path() . "/media/posts/" . $post->image);
				$post->delete();
				break;
			case Publication::$type["EVENT"]:
				$post = Game::find($id);
				unlink(public_path() . "/media/posts/" . $post->image);
				$post->delete();
				break;
		}

		Publication::destroy($id);
		if($redirect)
			return Redirect::route("post-list");
			
	}

	public function create(){
		$credentials = array_where(Input::except("_token"), function($index,$value){
			return !empty($value);
		});
		$credentials["author"] = Auth::user()->email;

		$rules = [
			"title" => "required|max:60", "type" => "required|in:post,game",
			"lang" => "required|in:es,en",
			"description" => "required",
			"excerpt" => "required|max:400",
		];

		if($credentials["type"] == "game"){
			$date = time() + (6 * 24 * 60 * 60);

			$rules["sports"] = "required";
			$rules["price"] = "numeric|min:0";
			$rules["end_register"] = "required|date|after:" . date('Y-m-d',$date);
			$rules["date"] = "required|date" . (isset($credentials["end_register"])? "|after:" . $credentials["end_register"] : "");
		}


		$validator = Validator::make(
			$credentials,
			$rules
		);

		if($validator->fails())
			return Redirect::route($credentials["type"] . "-new")->withErrors($validator->messages())->with("credentials",$credentials);
		try{
			$credentials["image"] = Utils::upload(Input::file("image"),"posts");

			if(!$credentials["image"]) {
				$validator->messages()->add("image",trans("messages.image-required"));
				return Redirect::route($credentials["type"] . "-new")->withErrors($validator->messages())->with("credentials",$credentials);
			}

		}catch (Exception $e){
			$validator->messages()->add("size",trans("messages.image-size"));
			return Redirect::route($credentials["type"] . "-new")->withErrors($validator->messages())->with("credentials",$credentials);
		}

		$data =  ["type" => $credentials["type"], "title" => $credentials["title"], "lang" => $credentials["lang"], "author" => $credentials["author"]];
		$publication = new Publication();

		foreach ($data as $key => $value) {
			$publication->$key = $value;
		}

		$publication->save();
		if($credentials["type"] == "game")
			Game::create(["id" => $publication->id, "description" => $credentials["description"], "excerpt" => $credentials["excerpt"],"image" => $credentials["image"],"date" => $credentials["date"],"end_register" => $credentials["end_register"],"price" => (isset($credentials["price"]))?$credentials["price"]:"0"]);
		else
			Post::create(["id" => $publication->id, "description" => $credentials["description"], "excerpt" => $credentials["excerpt"],"image" => $credentials["image"]]);

		if(isset($credentials["sports"])){
			$credentials["sports"] = json_decode($credentials["sports"]);
			foreach ($credentials["sports"] as $sport) {
				PSport::create(["publication" => $publication->id,"sport" => $sport]);
			}
		}

		if(isset($credentials["provinces"])){
			$credentials["provinces"] = json_decode($credentials["provinces"]);
			foreach ($credentials["provinces"] as $province) {
				PProvince::create(["publication" => $publication->id,"province" => $province]);
			}
		}

		return Redirect::route("post-list");
	}

	public function update($id){
		$credentials = array_where(Input::except("_token"), function($index,$value){
			return !empty($value);
		});

		$rules = [
			"title" => "max:60",
			"type" => "in:post,game",
			"lang" => "in:es,en",
			"excerpt" => "max:400",
		];

		if($credentials["type"] == "game"){
			$date = time();

			$rules["price"] = "numeric|min:0";
			$rules["end_register"] = "date|after:" . date('Y-m-d',$date);
			$rules["date"] = "date" . (isset($credentials["end_register"])? "|after:" . $credentials["end_register"] : "");
		}

		$validator = Validator::make(
			$credentials,
			$rules
		);


		if($validator->fails())
			return Redirect::route("post-edit",$id)->withErrors($validator->messages())->with("credentials",$credentials);
		try{
			$credentials["image"] = Utils::upload(Input::file("image"),"posts");

		}catch (Exception $e){
			$validator->messages()->add("size",trans("messages.image-size"));
			return Redirect::route("post-edit",$id)->withErrors($validator->messages())->with("credentials",$credentials);
		}
		
		$publication = Publication::find($id);
		$data = [];
		// check if there are changes and update
		if(isset($credentials["type"]) || isset($credentials["title"]) || isset($credentials["lang"]) || isset($credentials["author"])){
			if ($credentials["type"]) 
				$data["type"] = $credentials["type"];
			if ($credentials["title"]) 
				$data["title"] = $credentials["title"];
			if ($credentials["lang"]) 
				$data["lang"] = $credentials["lang"];
			if ($credentials["author"]) 
				$data["author"] = $credentials["author"];
			
			foreach ($data as $key => $value) {
				$publication->$key = $value;
			}

			$publication->save();
			$publication->touch();
		}

		//check if there are changes in relations model and save

		$data = [];

		if(isset($credentials["description"]) || isset($credentials["excerpt"]) || isset($credentials["image"]) ){
			if ($credentials["description"]) 
				$data["description"] = $credentials["description"];
			if ($credentials["excerpt"]) 
				$data["excerpt"] = $credentials["excerpt"];
			if ($credentials["image"]) {
				$data["image"] = $credentials["image"];
			}
		}

		if($publication->type == "game"){
			$post = Game::find($id);
			
			if(isset($credentials["price"]) || isset($credentials["date"]) || isset($credentials["end_register"]) ){
				if ($credentials["price"]) 
					$data["price"] = $credentials["price"];
				if ($credentials["date"]) 
					$data["date"] = $credentials["date"];
				if ($credentials["end_register"]) 
					$data["end_register"] = $credentials["end_register"];
				if(isset($data["image"]))
					unlink(public_path() . "/media/posts/" . $post->image);
			}


			foreach ($data as $key => $value) {
				$post->$key = $value;
			}
		}
		else{
			$post = Post::find($id);

			if(isset($data["image"]))
					unlink(public_path() . "/media/posts/" . $post->image);
				
			foreach ($data as $key => $value) {
				$post->$key = $value;
			}
		}

		$post->save();

		// check if need update PSport
		if(isset($credentials["sports"])){
			$credentials["sports"] = json_decode($credentials["sports"]);

			if(count($credentials["sports"])) PSport::where("publication", "=" , $id)->delete();

			foreach ($credentials["sports"] as $sport) {
				PSport::create(["publication" => $id,"sport" => $sport]);
			}
		}

		// check if need update PProvince
		if(isset($credentials["provinces"])){
			$credentials["provinces"] = json_decode($credentials["provinces"]);

			if(count($credentials["provinces"])) PProvince::where("publication", "=" , $id)->delete();

			foreach ($credentials["provinces"] as $province) {
				PProvince::create(["publication" => $id,"province" => $province]);
			}
		}

		return Redirect::route("post-list");
	}

	public function vote($id){
		Vote::create(["publication" => $id, "user" => Auth::user()->email]);

		$publication = Publication::find($id);

		$publication->votes++;
		$publication->save();

		return Response::json(["votes" => $publication->votes,"url" => route("delete-vote",$id),"class" => "voted"]);
	}

	public function deleteVote($id){
		Vote::where("publication", "=", $id)->where("user","=", Auth::user()->email)->delete();

		$publication = Publication::find($id);

		$publication->votes--;
		$publication->save();

		return Response::json(["votes" => $publication->votes,"url" => route("vote",$id),"class" => "novoted"]);
	}

}
