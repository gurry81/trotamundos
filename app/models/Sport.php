<?php

class Sport extends Eloquent{

	protected $table = 'sport';
	protected $fillable = ["name","name-es","icon"];
	public $timestamps = false;

	public function publications(){
		return $this->hasMany('PSport','sport','id');
	}
}