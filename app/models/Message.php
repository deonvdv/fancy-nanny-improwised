<?php

namespace Models;

class Message extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	
	protected $table = 'messages';

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function user()
    {
        return $this->belongsTo('Models\User');
    }


}
