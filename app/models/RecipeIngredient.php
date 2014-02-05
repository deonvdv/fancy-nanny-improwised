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
        return $this->belongsTo('Models\Recipe', 'recipe_id');
    }

    public function unit_of_measure()
    {
        return $this->belongsTo('Models\UnitOfMeasure');
    }

	public function ingredient()
    {
        return $this->belongsTo('Models\Ingredient');
    }	


    public function setRecipe(\Models\Recipe $recipe) {
        $this->recipe()->associate( $recipe );
        $this->save();
    }

    public function setUnitOfMeasure(\Models\UnitOfMeasure $unit_of_measure) {
        $this->save();
        $this->unit_of_measure()->associate( $unit_of_measure );
    }

    public function setIngredient(\Models\Ingredient $ingredient) {
        $this->save();
        $this->ingredient()->associate( $ingredient );
    }

}
