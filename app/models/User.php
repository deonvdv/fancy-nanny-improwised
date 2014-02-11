<?php

namespace Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	public static $rules = array(
  //       "name" => "required|between:4,100", 
  //       "email" => "required|email|unique:users", 
  //       "household_id" => "required_if:role,parent|required_if:role,gaurdian|required_if:role,child|required_if:role,staff|size:36", 
		// 'password' => 'required|alpha_num|min:8',
    );


	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function profile_picture()
    {
        return $this->hasOne('Models\Picture', 'id','profile_picture_id');
    }

	public function documents()
    {
        return $this->hasMany('Models\Document', 'owner_id');
    }

	public function events()
    {
        return $this->hasMany('Models\Event', 'owner_id');
    }

	public function messages_sent()
    {
        return $this->hasMany('Models\Message', 'sender_id');
    }

	public function messages_received()
    {
        return $this->hasMany('Models\Message', 'receiver_id');
    }

	public function notifications()
    {
        return $this->hasMany('Models\Notification');
    }

	public function recipes()
    {
        return $this->hasMany('Models\Recipe', 'author_id');
    }

    public function favoriterecipes()
    {
    	return $this->belongsToMany('Models\Recipe', 'favorite_recipes');
    }

	public function tags()
    {
        return $this->hasMany('Models\Tag', 'owner_id');
    }

	public function todos()
    {
        return $this->hasMany('Models\Todo', 'owner_id');
    }

	public function pictures()
    {
        return $this->morphMany('Models\Picture', 'imageable');
    }



    public function setHousehold(\Models\Household $household) {
        $household->save();
        $this->household_id = $household->id;
        $this->household()->associate( $household );
        $this->save();
    }

    public function addProfilePicture(\Models\Picture $picture) {
        $this->profile_picture_id = $picture->id;
        $picture->owner()->associate( $this );
        $picture->imageable_id = $this->id;
        $picture->imageable_type = 'Profile Picture';
        $picture->save();
        // print_r($picture);
        $this->save();
        // $this->profile_picture()->save( $picture );
        
    }

    public function addDocument(\Models\Document $document) {
        $this->save();
        $this->documents()->save( $document );
    }

    public function addEvent(\Models\Event $event) {
        $this->save();
        $this->events()->save( $event );
    }

    public function addMessageSent(\Models\Message $message) {
        $this->save();
        $this->messages_sent()->save( $message );
    }

    public function addMessageReceived(\Models\Message $message) {
        $this->save();
        $this->messages_received()->save( $message );
    }

    public function addNotification(\Models\Notification $notification) {
        $this->save();
        $this->notifications()->save( $notification );
    }

    public function addRecipe(\Models\Recipe $recipe) {
        $this->save();
        $this->recipes()->save( $recipe );
    }

    public function addFavoriteRecipe(\Models\Recipe $recipe) {
        $this->save();
        $this->favoriterecipes()->attach( $recipe );
    }

    public function addTag(\Models\Tag $tag) {
        $this->save();
        $this->tags()->save( $tag );
        $tag->setOwner( $this );      
    }

    public function addTodo(\Models\Todo $todo) {
        $this->save();
        $this->todos()->save( $todo );
		$todo->setOwner( $this );              
    }

    public function addPicture(\Models\Picture $picture) {
        $this->save();
        $this->pictures()->save( $picture );
        $picture->setOwner( $this );      
    }


	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}