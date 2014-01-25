<?php

namespace Models;

class Todo extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function tags()
    {
        return $this->morphMany('\Models\Tag', 'tagable');
    }

}
