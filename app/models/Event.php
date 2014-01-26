<?php 

namespace Models;

class Event extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function user()
    {
        return $this->belongsTo('Models\User', 'user_id');
    }

    public function tags()
    {
        return $this->morphMany('\Models\Tag', 'tagable');
    }

}
