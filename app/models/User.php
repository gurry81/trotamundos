<?php

use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface{
	public static $type = ["ALL" => "all", "NORMAL" => "normal" ,"AUTHOR" => "author", "VIP" => "organization", "ADMIN" => "admin"];
	protected $table = 'user';
	protected $primaryKey = 'email';
	public $incrementing = false;
	protected $fillable = ["email","nick","password","type","image"];
	protected $hidden = ["password"];

	public function publication(){
		return $this->hasMany('Publication','author','email');
	}

	// ABSTRACT METHODS OF UserInterface
	public function getAuthIdentifier(){
		return $this->getKey();
	}

	public function getAuthPassword(){
		return $this->password;
	}

	public function getRememberToken(){
		return $this->remember_token;
	}

	public function setRememberToken($value){
		$this->remember_token = $value;
	}

	public function getRememberTokenName(){
		return 'remember_token';
	}

	/*
	*@return a list of publication limited with author and sports
	*@param $options (Query->$options)
	*/

	 public static  function getUsers($options){

	 	// QUERY BASE
	 	$query ='User::select("image","email","nick","type")';
	 	// TYPE
		if($options["type"] == self::$type['ALL']){
			$types =array_values(self::$type);
			unset($types["ALL"]);
		}else{
			$types = [$options["type"]];
		}

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
		$query.= '	->whereIn("type",$types)
					->skip($options["skip"])
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
			
			if(Input::has("type")){
				$options ["type"] = Input::get("type");
			}
		}
	}
}
