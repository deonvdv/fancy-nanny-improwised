<?php

class Meal extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	protected $table = 'meals';

	public function household()
    {
        return $this->belongsTo('Household');
    }

	public function getMealsByHouseholds($household_id) {
		return $this->where('household_id', '=', $household_id)->get();
	}
}
