<?php
namespace Model;
use \Model\Recipe;
class Picture extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getPicturesByRecipe($recipe_id) {
		$picture_id = Recipe::find($recipe_id)->picture_id;
		return $this->where('id', '=', $picture_id)->get();
	}
}
