<?php 

namespace Models;

class Event extends BaseModel {
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

    public function tags()
    {
        return $this->morphMany('\Models\Tag', 'tagable');
    }

    public function setOwner(\Models\User $user) {
        $this->save();
        $this->owner()->associate( $user );
        $this->household()->associate( $user->household );
    }

    public function setHousehold(\Models\Household $household) {
        $this->save();
        $this->household()->associate( $household );
    }

}
