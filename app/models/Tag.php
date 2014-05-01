<?php

namespace Models;

class Tag extends BaseModel {
	protected $guarded = array('id');

    public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'owner_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'name' => 'required|min:3|max:255',
        'color' => array('required','min:4','max:7','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/')
    );

	public function owner()
    {
        return $this->belongsTo('Models\User');
    }

    public function recipes()
    {
        return $this->morphedByMany('Model\Recipe', 'taggable');
    }

    public function meals()
    {
        return $this->morphedByMany('Model\Meal', 'taggable');
    }

    public function events()
    {
        return $this->morphedByMany('Model\Event', 'taggable');
    }

    public function todos()
    {
        return $this->morphedByMany('Model\Todo', 'taggable');
    }

    public function documents()
    {
        return $this->morphedByMany('Model\Document', 'taggable');
    }

    public function setOwner(\Models\User $user) {
        $user->save();
        $this->owner()->associate( $user );
    }
}