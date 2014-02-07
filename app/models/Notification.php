<?php

namespace Models;

class Notification extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function user() {
        return $this->belongsTo('Models\User');
    }

	public function household() {
        return $this->belongsTo('Models\Household');
    }

    public function setUser(\Models\User $user) {
        $this->user()->associate( $user );
        $this->household()->associate( $user->household );
        $this->save();
    }

    public function setHousehold(\Models\Household $household) {
        $this->household()->associate( $household );
        $this->save();
    }

}
