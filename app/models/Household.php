<?php

namespace Models;

class Household extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        "name" => "required|between:4,255", 
    );

    public function documents() {
        return $this->hasMany('Models\Document');
    }

    public function members() {
        return $this->hasMany('Models\User');
    }

    public function messages() {
        return $this->hasMany('Models\Message');
    }

    public function tags() {
        return $this->hasMany('Models\Tag');
    }

    public function meals() {
        return $this->hasMany('Models\Meal');
    }

    public function events() {
        return $this->hasMany('Models\Event');
    }

    public function todos() {
        return $this->hasMany('Models\Todo');
    }

    public function notifications() {
        return $this->hasMany('Models\Notification');
    }



    public function addDocument(\Models\Document $document) {
        $this->save();
        $this->documents()->save( $document );
    }

    public function addMember(\Models\User $member) {
        $this->save();
        $this->members()->save( $member );
        $member->setHousehold( $this );
    }

    public function addMessage(\Models\Message $message) {
        $this->save();
        $this->messages()->save( $message );
    }

    public function addTag(\Models\Tag $tag) {
        $this->save();
        $this->tags()->save( $tag );
    }

    public function addMeal(\Models\Meal $meal) {
        $this->save();
        $this->meals()->save( $meal );
    }

    public function addEvent(\Models\Event $event) {
        $this->save();
        $this->events()->save( $event );
    }

    public function addTodo(\Models\Todo $todo) {
        $this->save();
        $this->todos()->save( $todo );
    }

    public function addNotification(\Models\Notification $notification) {
        $this->save();
        $this->notifications()->save( $notification );
    }



}
