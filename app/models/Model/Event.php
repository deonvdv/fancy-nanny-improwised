<?php
namespace Model;
class Event extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getEventsByHouseholdes($household_id) {
		return $this->where('household_id', '=', $household_id)->get();
	}
}
