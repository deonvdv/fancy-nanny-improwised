<?php

namespace Models;

class Document extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function user()
    {
        return $this->belongsTo('Models\User');
    }

	
}
