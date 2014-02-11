<?php

namespace Models;

class Recipe extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'id' => 'required|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'author_id' => 'required|exists:users,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',
        'name' => 'required|min:3|max:255',
        'description' => 'required|min:1|max:255',
        'instructions' => 'required|min:1|max:255',       
        'preparation_time' => 'required|date_format:H:i:s',
        'cooking_time' => 'required|date_format:H:i:s',    
        'category_id' => 'exists:categories,id|regex:/^\{?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\}?$/',   
    );

    public function reviews() {
        return $this->hasMany('Models\RecipeReview');
    }

    public function recipe_ingredients() {
        return $this->hasMany('Models\RecipeIngredient');
    }

	public function tags()
    {
        return $this->morphMany('\Models\Tag', 'tagable');
    }

	public function pictures()
    {
        return $this->morphMany('Models\Picture', 'imageable');
    }

	public function category()
    {
        return $this->belongsTo('Models\Category');
    }	

	public function meals()
    {
        return $this->belongsToMany('Models\Meal', 'meals_recipes');
    }	

	public function author()
    {
        return $this->belongsTo('Models\User');
    }



    public function setAuthor(\Models\User $user) {
        $this->author()->associate( $user );
        $this->save();
    }

    public function setCategory(\Models\Category $category) {
        $this->save();
        $this->category()->associate( $category );
    }

    public function addTag(\Models\Tag $tag) {
        $this->save();
        $this->tags()->save( $tag );
    }

    public function addPicture(\Models\Picture $picture) {
        $this->save();
        $this->pictures()->save( $picture );
    }

    public function addRecipeIngredient(\Models\RecipeIngredient $recipeIngredient) {
        $this->save();
        $this->recipe_ingredients()->save( $recipeIngredient );
    }

    public function addReview(\Models\RecipeReview $recipeReview) {
        $this->save();
        $this->reviews()->save( $recipeReview );
    }

}
