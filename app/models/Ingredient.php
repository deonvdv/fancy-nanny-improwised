<?php

namespace Models;

class Ingredient extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(            
		'id'        => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
		'name'      => 'required|min:3|max:255',
    );

	public function recipe_ingredient()
    {
        return $this->hasMany('Models\RecipeIngredient');
    }	
    
}
