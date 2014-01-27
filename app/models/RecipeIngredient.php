<?php

namespace Models;

/**
 * 	Summary:	Place to store ingredients for a specific recipe, eg 1 x Tbsp Plain 
 *				Flour. Unit of Measure is "tbsp" and ingredient is "Plain Flour"
 *	UI Notes:	When adding a recipe, and adding recipe ingredients, allow a input 
 *				area for Quantity, numberic (allow for fractions like 0.5 and whole 
 *				numbers like 5 or 5.5 ), and allow for predictive search window 
 *				for Unit of Measure. When user types in "t", return "tsp", "tbsp", 
 *				etc. Allow for another predicitve text area for ingredient, eg user 
 *				types in "fl" and we return "Plain Flour", "Cake Flour", etc. Note: 
 *				if user's desired Unit of Measure or Ingredient does not exists, it 
 *				needs to be added dynamically.				
 *
 */
class RecipeIngredient extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

    public function recipe()
    {
        return $this->hasOne('Models\Recipe');
    }

    public function unit_of_measure()
    {
        return $this->hasOne('Models\UnitOfMeasure', 'unit_of_measure_id');
    }

	public function ingredient()
    {
        return $this->belongsToMany('Models\Ingredient', 'ingredients_recipeingredients');
    }	

}