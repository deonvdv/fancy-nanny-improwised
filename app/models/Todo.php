<?php

namespace Models;

class Todo extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array();

    public function owner()
    {
        return $this->belongsTo('Models\User');
    }

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function tags()
    {
        return $this->morphMany('\Models\Tag', 'tagable');
    }

    public function assigned_by()
    {
        return $this->belongsTo('Models\User','assigned_by');
    }

    public function assigned_to()
    {
        return $this->belongsTo('Models\User','assigned_to');
    }


    public function setOwner(\Models\User $user) {
        $user->save();
        $this->owner()->associate( $user );
        $this->household()->associate( $user->household );
        $this->save();
    }

    public function setHousehold(\Models\Household $household) {
        $household->save();
        $this->household()->associate( $household );
        $this->save();
    }

    public function setAssignedBy(\Models\User $user) {
        $user->save();
        $this->assigned_by()->associate( $user );
        $this->save();
    }

    public function setAssignedTo(\Models\User $user) {
        $user->save();
        $this->assigned_to()->associate( $user );
        $this->save();
    }


}
