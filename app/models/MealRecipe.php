<?php

namespace Models;

class MealRecipe extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getMealsByRecipe($recipe_id) {
		return $this->where('recipe_id', '=', $recipe_id)->get();
	}
	public function getMealRecipesByMeal($id)
	{
		return $this->where('meal_id', '=', $id)->get();
	}
}
