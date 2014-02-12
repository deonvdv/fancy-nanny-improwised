<?php

namespace Models;

class RecipeReview extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'recipe_id' => 'required|exists:recipes,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'user_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'score' => 'required|numeric|between: 1,5',
    );

	public function recipe()
    {
        return $this->belongsTo('Models\Recipe');
    }

	public function user()
    {
        return $this->belongsTo('Models\User');
    }

    public function setUser(\Models\User $user) {
        $this->user()->associate( $user );
        $this->save();
    }

    public function setRecipe(\Models\Recipe $recipe) {
        $this->recipe()->associate( $recipe );
        $this->save();
    }
}
