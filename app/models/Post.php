<?php 
	class Post extends Eloquent{

		protected $table = 'new';
		public $incrementing = false;
		public $timestamps = false;
		protected $fillable = ["id","image","excerpt","description"];

		public function sports(){
			return $this->hasMany('PSport','publication');
		}

		public function province(){
			return $this->hasOne('PProvince','publication');
		}

		public function publication(){
			return $this->hasOne('Publication','id');
		}

	}

 ?>