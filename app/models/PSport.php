<?php 
	class PSport extends Eloquent{

		protected $table = 'publi_sport';
		protected $primarykey = ["publication","sport"];
		protected $fillable = ["publication", "sport"];
		public $timestamps = false;
		public $incrementing = false;
		

		public function publication(){
			return $this->hasOne('Publication','id','publication');
		}

	}

 ?>