<?php 
	class Game extends Eloquent{

		protected $table = 'game';
		public $incrementing = false;
		public $timestamps = false;
		protected $fillable = ["id","image","excerpt","description","date","end_register","price"];

		public function sports(){
			return $this->hasMany('PSport','publication');
		}

		public function province(){
			return $this->hasMany('PProvince','publication');
		}

		public function publication(){
			return $this->hasOne('Publication','id');
		}

		public function player(){
			return $this->hasMany('Player','game',"id");
		}

		static function register($user,$game){
			Player::create(["game" => $game, "user" => $user]);
		}

		public function end_Register(){
			$current = time();
			$event = strtotime($this->end_register);

			if($current > $event)
				return true;
			return false;
		}

		public function finished(){
						$current = time();
			$event = strtotime($this->date);

			if($current > $event)
				return true;
			return false;
		}

	}

 ?>