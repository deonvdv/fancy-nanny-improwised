<?php
namespace Model;
class MealRecipe extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getMealsByRecipe($recipe_id) {
		return $this->where('recipe_id', '=', $recipe_id)->get();
	}
}
