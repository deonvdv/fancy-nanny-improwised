<?php
namespace Model;
class Message extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();
	protected $table = 'messages';
	public function getMessagesByHouseholds($household_id) {
		return $this->where('household_id', '=', $household_id)->get();
	}
}
