<?php 

	class UserController extends BaseController
	{
		
		function login(){

			$credentials = Input::only("email","password");
			$rules = [
				"email" => "required|email|max:60",
				"password" => "required|max:60"
			];

			$validator = Validator::make(
				$credentials,
				$rules
			);

			if($validator->fails())
				return Redirect::route("login-form")->withErrors($validator->messages())->with("credentials",$credentials);
				
			if(Auth::attempt($credentials))
				// return Redirect::route("dashboard");	
				return Redirect::back();			

			$validator->messages()->add("login",trans("messages.login-error"));

			return Redirect::route("login-form")->withErrors($validator->messages())->with("credentials",$credentials);
		}

		function logout(){
			if(Auth::check())
				Auth::logout();
			
			return Redirect::to("/");
		}

		function register(){
			$credentials = Input::except("_token");
			$rules = [
				"email" => "required|email|max:60|unique:user",
				"nick" => "required|max:20|unique:user",
				"password" => "required|max:60|confirmed",
			];

			$validator = Validator::make(
				$credentials,
				$rules
			);

			if($validator->fails())
				return Redirect::route("register-form")->withErrors($validator->messages())->with("credentials",$credentials);
			try{
				$credentials["image"] = Utils::upload(Input::file("image"),"images");
				if(!$credentials["image"])
					$credentials["image"] = "default.jpg";
			}catch (Exception $e){
				$validator->messages()->add("size",trans("messages.image-size"));
				return Redirect::route("register-form")->withErrors($validator->messages())->with("credentials",$credentials);
			}

			$credentials["password"] = Hash::make($credentials["password"]);
			User::create($credentials);

			return Redirect::route("login-form")->with("credentials",["email"=>$credentials["email"]]);
		}

		function delete($email){
			$user = User::find($email);

			$posts = Publication::where("author", "=" , $email)->get();
			$pController = new PublicationController();

			foreach ($posts as $post) {
				$pController->delete($post->id, false);
			}

			unlink(public_path() . "/media/images/" . $user->image);
			$user->delete();

			return Redirect::route("user-list");
		}

		function create(){
			$credentials = Input::except("_token");
			$credentials["type"] =  $credentials["type"]? $credentials["type"]: User::$type["NORMAL"];

			$rules = [
				"email" => "required|email|max:60|unique:user",
				"nick" => "required|max:20|unique:user",
				"password" => "required|max:60|confirmed",
				"type" => "in:normal,author,organization,admin",
			];

			$validator = Validator::make(
				$credentials,
				$rules
			);

			if($validator->fails())
				return Redirect::route("user-new")->withErrors($validator->messages())->with("credentials",$credentials);
			try{
				$credentials["image"] = Utils::upload(Input::file("image"),"images");
				if(!$credentials["image"])
					$credentials["image"] = "default.jpg";
			}catch (Exception $e){
				$validator->messages()->add("size",trans("messages.image-size"));
				return Redirect::route("user-new")->withErrors($validator->messages())->with("credentials",$credentials);
			}

			$credentials["password"] = Hash::make($credentials["password"]);
			User::create($credentials);

			return Redirect::route("user-list");
		}

		function update(){
			$credentials = array_where(Input::except("_token","old-email"), function($key,$value){
				return !empty($value);
			});

			$old_email = Input::get("old-email");
			$user = User::find($old_email);

			$rules = [
				"email" => "required|email|max:60",
				"nick" => "required|max:20",
				"password" => "max:60|confirmed",
				"type" => "in:normal,author,organization,admin",
			];

			$validator = Validator::make(
				$credentials,
				$rules
			);

			if($validator->fails())
				return Redirect::route("user-edit",$old_email)->withErrors($validator->messages())->with("credentials",$credentials);
			// delete duplicate and useless vars
			if($credentials["email"]  == $user->email)
				unset($credentials["email"]);
			if($credentials["nick"]  == $user->nick)
				unset($credentials["nick"]);
			unset($credentials["password_confirmation"]);

			$rules = [
				"email" => "unique:user",
				"nick" => "unique:user",
			];

			$validator = Validator::make(
				$credentials,
				$rules
			);

			if($validator->fails())
				return Redirect::route("user-edit",$old_email)->withErrors($validator->messages())->with("credentials",$credentials);

			try{
				$credentials["image"] = Utils::upload(Input::file("image"),"images");
				if(!$credentials["image"])
					unset($credentials["image"]);
				else if ($user->image != "default.jpg")
					unlink(public_path() . "/media/images/" . $user->image);
				
				
			}catch (Exception $e){
				$validator->messages()->add("size",trans("messages.image-size"));
				return Redirect::route("user-edit",$old_email)->withErrors($validator->messages())->with("credentials",$credentials);
			}

			foreach ($credentials as $key => $value) {
				if($key == "password")
					$value = Hash::make($value);
				$user->$key = $value;
			}

			if($old_email  != $user->email){
				$posts = Publication::where("author","=", $old_email)->get();

				foreach ($posts as $post) {
					$post->author = $user->email;
					$post->save();
				}
			}

			$user->save();

			if($old_email == Auth::user()->email){
				Auth::logout();
				Auth::login($user);
			}

			return Redirect::route("user-edit", $user->email);
		}
	}
 ?>