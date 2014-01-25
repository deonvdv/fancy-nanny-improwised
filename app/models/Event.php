<?php

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

	public function getEventsByHouseholdes($household_id) {
		return $this->where('household_id', '=', $household_id)->get();
	}
}
