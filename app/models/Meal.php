<?php

namespace Models;

class Meal extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	protected $table = 'meals';

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function tags()
    {
        return $this->morphMany('\Models\Tag', 'tagable');
    }

}
