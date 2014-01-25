<?php

class MealTag extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getMealTagsByMeal($meal_id)
	{
		return $this->where('meal_id', '=', $meal_id)->get();
	}
}
