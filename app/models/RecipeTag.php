<?php

namespace Models;

class RecipeTag extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getTagByRecipes($recipe_id) {
		return $this->where('recipe_id', '=', $recipe_id)->get();
	}
}
