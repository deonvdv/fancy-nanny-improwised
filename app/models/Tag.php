<?php

namespace Models;

class Tag extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function owner()
    {
        return $this->belongsTo('Models\User');
    }

	public function tagable()
    {
        return $this->morphTo();
    }    


    public function setOwner(\Models\User $user) {
        $this->owner()->associate( $user );
        $this->household()->associate( $user->household );
        $this->save();
    }

    public function setHousehold(\Models\Household $household) {
        $this->save();
        $this->household()->associate( $household );
    }


}
