<?php

namespace Models;

class Ingredient extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function recipe_ingredients()
    {
        return $this->belongsToMany('Models\RecipeIngredient', 'ingredients_recipeingredients');
    }	
    
}
