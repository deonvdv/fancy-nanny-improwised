<?php

namespace Models;

class Ingredient extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function recipe_ingredient()
    {
        return $this->hasMany('Models\RecipeIngredient');
    }	
    
}
