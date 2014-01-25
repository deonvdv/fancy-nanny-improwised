<?php 

namespace Models;

class Event extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function household()
    {
        return $this->belongsTo('Household');
    }

	public function user()
    {
        return $this->belongsTo('User');
    }

}
