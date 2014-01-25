<?php

namespace Models;

class RecipeReview extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getReviewsByRecipe($recipe_id) {
		return $this->where('recipe_id', '=', $recipe_id)->get();
	}
}
