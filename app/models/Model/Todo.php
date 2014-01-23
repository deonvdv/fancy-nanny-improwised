<?php
namespace Model;
class Todo extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	public function getTodosByHouseholdes($household_id) {
		return $this->where('household_id', '=', $household_id)->get();
	}
}
