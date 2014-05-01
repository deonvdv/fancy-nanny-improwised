<?php 

namespace Models;

class Event extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'owner_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'title' => 'required|min:3|max:255',
        'location' => 'min:0|max:255',
        'event_date' => 'date',
        'start_time' => 'date_format:H:i:s',
        'end_time' => 'date_format:H:i:s',
        'notify' => 'min:0|max:255',
        'type' => 'required|min:3|max:255',
        'minutes_before' => 'required|Integer|between:1,59',
    );

	public function owner() {
        return $this->belongsTo('Models\User');
    }

    public function tags() {
        return $this->morphMany('\Models\Tag', 'taggable');
    }

    public function attendees() {
        return $this->belongsToMany('Models\User', 'events_attendees');
    }

    public function setOwner(\Models\User $user) {
        $user->save();
        $this->owner()->associate( $user );
        $this->save();
    }

    public function addAttendee(\Models\User $user) {
        $user->save();
        $this->save();
        $this->attendees()->attach( $user );
    }

}
