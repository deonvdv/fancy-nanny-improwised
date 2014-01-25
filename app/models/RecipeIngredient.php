<?php

class RecipeIngredient extends BaseModel {
	protected $guarded = array('id');
	public static $rules = array();
	public function getRecipeIngredientsByRecipe($recipe_id) {
		return $this->where('recipe_id', '=', $recipe_id)->get();
	}
}
