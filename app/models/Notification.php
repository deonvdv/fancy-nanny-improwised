<?php

namespace Models;

class Notification extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function household()
    {
        return $this->belongsTo('Household');
    }

	public function getNotificationsByHouseholdes($household_id) {
		return $this->where('household_id', '=', $household_id)->get();
	}
}
