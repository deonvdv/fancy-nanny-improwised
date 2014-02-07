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
        "name" => "required|between:4,100", 
        "email" => "required|email|unique:users", 
        "household_id" => "required_if:role,parent|required_if:role,gaurdian|required_if:role,child|required_if:role,staff|size:36", 
		'password' => 'required|alpha_num|min:8',
    );


	public function profile_picture()
    {
        return $this->hasOne('Models\Picture', 'owner_id');
    }

	public function documents()
    {
        return $this->hasMany('Models\Document', 'owner_id');
    }

	public function events()
    {
        return $this->hasMany('Models\Event', 'owner_id');
    }

	public function household()
    {
        return $this->belongsTo('Models\Household');
    }

	public function messages()
    {
        return $this->hasMany('Models\Message');
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
        return $this->hasMany('Models\Tag');
    }

	public function todos()
    {
        return $this->hasMany('Models\Todo');
    }

	public function pictures()
    {
        return $this->morphMany('Models\Picture', 'imageable');
    }

    public function addFavoriteRecipe(\Models\Recipe $recipe) {
        $this->save();
        $this->favoriterecipes()->attach( $recipe );
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