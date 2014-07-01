<?php 
	class Vote extends Eloquent{

		protected $table = 'vote';
		protected $fillable = ["publication","user"];
		protected $primaryKey = ["publication","user"];
		public $timestamps = false;
		public $incrementing = false;

		public function user(){
			return $this->hasOne('User','id','user');
		}

		public function publication(){
			return $this->hasOne('Publication','id','publication');
		}

	}

 ?>