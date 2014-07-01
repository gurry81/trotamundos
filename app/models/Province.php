<?php

class Province extends Eloquent{

	protected $table = 'province';
	protected $fillable = ["name","name-es"];
	protected $timestamps = false;

	public function publications(){
		return $this->hasMany('PProvince','province','id');
	}
}