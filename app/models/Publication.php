<?php

class Publication extends Eloquent{
	public static $type = ['NEW' => 'post','EVENT'=>'game','ALL'=>'all'];
	protected $table = 'publication';
	protected $fillable = ["author","id","title","image","type","votes","lang"];

	public function post(){
		return $this->hasOne('Post','id');
	}

	public function game(){
		return $this->hasOne('Game','id');
	}

	// public function route(){
	// 	return $this->hasOne('Track','id');
	// }

	public function user(){
		return $this->hasOne('User','email','author');
	}

	public function sports(){
		return $this->hasMany('PSport','publication');
	}

	public function provinces(){
		return $this->hasMany('PProvince','publication');
	}

	/*
	*@return a single publication by id
	*@param $options (Query->$options)
	*/

	public static function getPublication($options){
		// QUERY BASE
	 	$query ='Publication::with(["sports" => function($query){
	 					$query->join("sport","sport.id","=","publi_sport.sport");
	 					}, 
	 					"provinces" => function($query){},
	 					"user" => function($query){},';
		//TYPE	 					
	 	if($options["type"] == self::$type['ALL']){
			$types =array_values(self::$type);
			array_pop($types);
			
			$typesJoin = [];
			foreach ($types as $type) {
				$typesJoin[] = '"' . $type . '" => function($query){}';
			}

			$query .= implode(",",$typesJoin);
			$query .= '])';
		}else{
			$types = [$options["type"]];
			$query .= '$options["type"] => function($query){}])';
		}

	 	// ID
		$query .= '->where("id","=",$options["id"])
					->get();';

		eval('$post = ' . $query);
		if(count($post) > 0)
			return $post[0];
		return false;
	}

	/*
	*@return a list of publication limited with author and sports
	*@param $options (Query->$options)
	*/

	 public static  function getPublications($options){

	 	// QUERY BASE
	 	$query ='Publication::with(["sports" => function($query){
	 					$query->join("sport","sport.id","=","publi_sport.sport");
	 					}, 
	 					"provinces" => function($query){},
	 					"user" => function($query){},';
	 	// TYPE
		if($options["type"] == self::$type['ALL']){
			$types =array_values(self::$type);
			array_pop($types);
			
			$typesJoin = [];
			foreach ($types as $type) {
				$typesJoin[] = '"' . $type . '" => function($query){}';
			}

			$query .= implode(",",$typesJoin);
			$query .= '])';
		}else{
			$types = [$options["type"]];
			$query .= '$options["type"] => function($query){}])';
		}

		// FILTERS
		if($options["sport"] || $options["province"] || $options["author"] || $options["title"]){
			
			if($options["sport"] && $options["sport"] != 5){
				$query .= '->join("publi_sport","publi_sport.publication","=","publication.id")
											->where("publi_sport.sport","=",$options["sport"])';
			}
			if($options["province"]){
				$query .= '->join("publi_prov","publi_prov.publication","=","publication.id")
											->where("publi_prov.province","=",$options["province"])';
			}
			if($options["author"]){
				$query .= '->where("author","LIKE","%' . $options["author"] . '%")';
			}
			if($options["title"]){
				$query .= '->where("title","LIKE","%' . $options["title"] . '%")';
			}
		}

		// LANG AND TYPES FILTER

		$query.= '	->whereIn("type",$types)';
		if($options["lang"])
			$query .= '->where("lang","=",App::getLocale())';
		
		// PAGINATION QUERY AND ORDER
		$query.= '	->skip($options["skip"])
					->take($options["limit"])
					->orderBy($options["orderby"],$options["order"])
					->get();';

		eval('$posts = ' . $query);

		if(count($posts) > 0)
			return $posts;
		return false;
	}

	static function filters(&$options){
		if(count(Input::all()) > 0){
			if(Input::has("sport")){
				$options["sport"] = Input::get("sport");
			}

			if(Input::has("author")){
				$options["author"] = Input::get("author");
			}

			if(Input::has("province")){
				$options ["province"] = Input::get("province");
			}

			if(Input::has("orderby")){
				$options ["orderby"] = Input::get("orderby");
			}

			if(Input::has("page")){
				$options ["page"] = Input::get("page");
			}
			// dashboards filters
			if(Input::has("type")){
				$options ["type"] = Input::get("type");
			}

			if(Input::has("title")){
				$options ["title"] = Input::get("title");
			}
		}
	}

	static function byAuthor($author,$except = null,$limit = 3){


		$query ='self::where("author","like",$author)';
		
		if($except !== null){
			$query.= '->whereNotIn("id",$except)';
		}

		$query .= '	->where("lang", "=" ,App::getLocale())
					->orderBy("created_at","DESC")
					->take($limit)
					->get();';

		eval('$posts = ' . $query);

		if(count($posts) > 0)
			return $posts;				
		return false;
	}

	static function byVotes($type = "all", $limit = 10){

		if ($type == self::$type["ALL"]){
			$posts = self::all()
							->where("lang", "=" ,App::getLocale())
							->orderBy('votes',"DESC")
							->orderBy('created_at',"DESC")
							->take($limit)
							->get();
							
			if(count($posts) > 0)
				return $posts;
			return false;
		}else{
			
			$posts = self::where("type","=",$type)
							->where("lang", "=" ,App::getLocale())
							->orderBy('votes',"DESC")
							->orderBy('created_at',"DESC")
							->take($limit)
							->get();

			if(count($posts) > 0)
				return $posts;
			return false;
		}
	}

	public static function remove($id){
		PSport::where("publication","=",$id)->delete();
		PProvince::where("publication","=",$id)->delete();
		$post = Publication::find($id);

		switch ($post->type) {
			case Publication::$type["NEW"]:
				Post::destroy($id);
				break;
			case Publication::$type["EVENT"]:
				Game::destroy($id);
				// Player::destory($id);
				break;
		}

		Publication::destroy($id);
			
	}

}
