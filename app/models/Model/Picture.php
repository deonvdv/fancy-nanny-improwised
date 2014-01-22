<?php
namespace Model;
class Picture extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getPicturesByRecipe($recipe_id) {
		return $this->where('recipe_id', '=', $recipe_id)->get();
	}
}
