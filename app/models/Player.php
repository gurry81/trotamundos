<?php 
	class Player extends Eloquent{

		public $timestamps = false;
		public $incrementing = false;
		protected $table = 'player';
		protected $primaryKey = ["user","game"];
		protected $fillable = ["user","game"];


		public function user(){
			return $this->hasOne('User','email',"user");
		}

		public function publication(){
			return $this->hasOne('Publication','id',"game");
		}

			/*
	*@return a list of publication limited with author and sports
	*@param $options (Query->$options)
	*/

	 public static  function getPlayers($options){

	 	// QUERY BASE
	 	$query ='Player::join("user","player.user","=","user.email")
	 				->where("player.game","=",$options["id"])
	 				->select("user.image as image","user.email as email","user.nick as nick")';

		// FILTERS
		if($options["email"] || $options["nick"] ){

			if($options["email"]){
				$query .= '->where("email","LIKE","%' . $options["email"] . '%")';
			}
			if($options["nick"]){
				$query .= '->where("nick","LIKE","%' . $options["nick"] . '%")';
			}
		}

		// PAGINATION QUERY AND ORDER
		$query.= '	->skip($options["skip"])
					->take($options["limit"])
					->orderBy($options["orderby"],$options["order"])
					->get();';

		eval('$users = ' . $query);

		if(count($users))
			return $users;
		return false;
	}

	static function filters(&$options){
		if(count(Input::all()) > 0){

			if(Input::has("email")){
				$options["email"] = Input::get("email");
			}

			if(Input::has("nick")){
				$options["nick"] = Input::get("nick");
			}

			if(Input::has("orderby")){
				$options ["orderby"] = Input::get("orderby");
			}

			if(Input::has("order")){
				$options ["order"] = Input::get("order");
			}

			if(Input::has("page")){
				$options ["page"] = Input::get("page");
			}
			
		}
	}

	}

 ?>