<?php

namespace Models;

class Todo extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'owner_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'title' => 'required|min:3|max:50',
        'due_date' => 'required|date',
        'assigned_by' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'assigned_to' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'minutes_before' => 'required|Integer|Min:1|Max:59',
    );

    public function owner()
    {
        return $this->belongsTo('Models\User');
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
