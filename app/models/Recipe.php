<?php

namespace Models;

class Recipe extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

    public function reviews() {
        return $this->hasMany('Models\RecipeReview');
    }

	public function tags()
    {
        return $this->morphMany('\Models\Tag', 'tagable');
    }

	public function pictures()
    {
        return $this->morphMany('Models\Picture', 'imageable');
    }

	public function category()
    {
        return $this->belongsTo('Models\Category', 'recipes_categories');
    }	

}
