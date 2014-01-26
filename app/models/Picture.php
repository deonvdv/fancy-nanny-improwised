<?php

namespace Models;

class Picture extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function owner()
    {
        return $this->belongsTo('Models\User');
    }

	public function imageable()
    {
        return $this->morphTo();
    }    

}
