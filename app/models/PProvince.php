<?php 
	class PProvince extends Eloquent{

		protected $table = 'publi_prov';
		protected $primarykey = ['publication','province'];
		protected $fillable = ["publication", "province"];
		public $timestamps = false;
		public $incrementing = false;

		public function publication(){
			return $this->hasOne('Publication','id','publication');
		}

	}

 ?>