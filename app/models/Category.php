<?php

namespace Models;

class Category extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function recipes()
    {
        return $this->hasMany('Models\Recipe');
    }	
}
