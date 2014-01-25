<?php

namespace Models;

class RecipeCategory extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getCategoryByRecipe($recipe_id) {
		return $this->where('recipe_id', '=', $recipe_id)->get();
		// return RecipeCategory::get();
		// return $this->where('recipe_id', '=', $recipe_id)->get();
	}
}
