<?php

namespace Models;

class Category extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(            
		'id'        => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
		'name'      => 'required|min:3|max:255',
		'parent_id' => 'exists:categories,id'
    );

	public function recipes()
    {
        return $this->hasMany('Models\Recipe');
    }	

	public function parent()
    {
        return $this->belongsTo('Models\Category');
    }	

    public function setParent(\Models\Category $category) {
        $this->save();
        $this->parent()->associate( $category );
    }

}
