<?php

namespace Models;

class RecipeReview extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function recipe()
    {
        return $this->belongsTo('Models\Recipe');
    }

	public function user()
    {
        return $this->belongsTo('Models\User');
    }

}
