<?php

namespace Models;

class Document extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function owner() {
        return $this->belongsTo('Models\User');
    }

	public function household() {
        return $this->belongsTo('Models\Household');
    }

    public function setOwner(\Models\User $user) {
        // print_r($user);
        $this->owner()->associate( $user );
        $this->household()->associate( $user->household );
        $this->save();
    }

    public function setHousehold(\Models\Household $household) {
        $this->household()->associate( $household );
        $this->save();
    }

	
}
