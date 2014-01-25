<?php
namespace Model;
class Tag extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function household()
    {
        return $this->belongsTo('Household');
    }

	public function getTagsByHouseholds($household_id) {
		return $this->where('household_id', '=', $household_id)->get();
	}
}
