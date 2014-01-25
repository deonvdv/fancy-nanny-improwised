<?php
namespace Model;
class Recipe extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getRecipesByUser($user_id)
	{
		return $this->where('user_id', '=', $user_id)->get();
	}
}
