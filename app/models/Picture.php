<?php

class Picture extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getPicturesByRecipe($recipe_id) {
		$picture_id = Recipe::find($recipe_id)->picture_id;
		return $this->where('id', '=', $picture_id)->get();
	}
	public function getPictursByUser($user_id) {
		return $this->where('user_id', '=', $user_id)->get();
	}
}
