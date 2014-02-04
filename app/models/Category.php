<?php

namespace Models;

class Category extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function recipes()
    {
        return $this->hasMany('Models\Recipe');
    }	

	public function parent()
    {
        return $this->belongsTo('Models\Category');
    }	

    public function addParent(\Models\Category $category) {
        $this->save();
        $this->parent()->associate( $category );
    }

}
