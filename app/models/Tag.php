<?php

namespace Models;

class Tag extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function user()
    {
        return $this->belongsTo('Models\User');
    }

	public function tagable()
    {
        return $this->morphTo();
    }    
}
