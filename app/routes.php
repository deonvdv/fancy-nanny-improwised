<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * API Route
 */

Route::group(array(
        'prefix'    => 'api/v1'
    ), function(){
        Route::get('households', 'API\V1\HouseholdController@index');
        Route::resource('household', 'API\V1\HouseholdController');
        Route::get('households/page/{pagenum}', 'API\V1\HouseholdController@index');
        Route::get('households/page/{pagenum}/{itemsperpage}', 'API\V1\HouseholdController@index');
        Route::get('household/{id}/documents', 'API\V1\HouseholdController@documents');
        Route::get('household/{id}/messages', 'API\V1\HouseholdController@messages');
        Route::get('household/{id}/tags', 'API\V1\HouseholdController@tags');
        Route::get('household/{id}/members', 'API\V1\HouseholdController@members');
        Route::get('household/{id}/meals', 'API\V1\HouseholdController@meals');
        Route::get('household/{id}/events', 'API\V1\HouseholdController@events');
        Route::get('household/{id}/todos', 'API\V1\HouseholdController@todos');
        Route::get('household/{id}/notifications', 'API\V1\HouseholdController@notifications');

        Route::resource('household_service', 'API\V1\HouseholdServiceController');
        Route::get('household_services', 'API\V1\HouseholdServiceController@index');
        
        Route::resource('user', 'API\V1\UserController');
        Route::get('users', 'API\V1\UserController@index');
        Route::get('user/{id}/picture', 'API\V1\UserController@picture');
        Route::get('user/{id}/recipes', 'API\V1\UserController@recipes');
        Route::get('user/{id}/favorite_recipes', 'API\V1\UserController@favorite_recipes');
        Route::get('users/page/{pagenum}', 'API\V1\UserController@index');
        Route::get('users/page/{pagenum}/{itemsperpage}', 'API\V1\UserController@index');

        Route::resource('message', 'API\V1\MessageController');
        Route::get('messages', 'API\V1\MessageController@index');
        Route::get('messages/page/{pagenum}', 'API\V1\MessageController@index');
        Route::get('messages/page/{pagenum}/{itemsperpage}', 'API\V1\MessageController@index');
        
        Route::resource('category', 'API\V1\CategoryController');
        Route::get('categories', 'API\V1\CategoryController@index');
        Route::get('categories/page/{pagenum}', 'API\V1\CategoryController@index');
        Route::get('categories/page/{pagenum}/{itemsperpage}', 'API\V1\CategoryController@index');
        
        Route::resource('tag', 'API\V1\TagController');
        Route::get('tags', 'API\V1\TagController@index');
        Route::get('tags/page/{pagenum}', 'API\V1\MessageController@index');
        Route::get('tags/page/{pagenum}/{itemsperpage}', 'API\V1\MessageController@index');
        
        Route::resource('units_of_measure', 'API\V1\MeasureUnitController');
        Route::get('units_of_measures', 'API\V1\MeasureUnitController@index');
        Route::get('units_of_measures/page/{pagenum}', 'API\V1\MeasureUnitController@index');
        Route::get('units_of_measures/page/{pagenum}/{itemsperpage}', 'API\V1\MeasureUnitController@index');
        
        Route::resource('ingredient', 'API\V1\IngredientController');
        Route::get('ingredients', 'API\V1\IngredientController@index');
        Route::get('ingredients/page/{pagenum}', 'API\V1\IngredientController@index');
        Route::get('ingredients/page/{pagenum}/{itemsperpage}', 'API\V1\IngredientController@index');

        Route::resource('recipe_ingredient', 'API\V1\RecipeIngredientController');
        Route::get('recipe_ingredients', 'API\V1\RecipeIngredientController@index');
        Route::get('recipe_ingredients/page/{pagenum}', 'API\V1\RecipeIngredientController@index');
        Route::get('recipe_ingredients/page/{pagenum}/{itemsperpage}', 'API\V1\RecipeIngredientController@index');
        
        Route::resource('recipe', 'API\V1\RecipeController');
        Route::get('recipes', 'API\V1\RecipeController@index');
        Route::get('recipes/page/{pagenum}', 'API\V1\RecipeController@index');
        Route::get('recipes/page/{pagenum}/{itemsperpage}', 'API\V1\RecipeController@index');
        Route::get('recipe/{id}/recipe_ingredients', 'API\V1\RecipeController@recipe_ingredients');
        Route::get('recipe/{id}/pictures', 'API\V1\RecipeController@pictures');
        Route::get('recipe/{id}/categories', 'API\V1\RecipeController@categories');
        Route::get('recipe/{id}/tags', 'API\V1\RecipeController@tags');
        Route::get('recipe/{id}/reviews', 'API\V1\RecipeController@reviews');

        Route::resource('recipe_review', 'API\V1\RecipeReviewController');
        Route::get('recipe_reviews', 'API\V1\RecipeReviewController@index');
        Route::get('recipe_reviews/page/{pagenum}', 'API\V1\RecipeReviewController@index');
        Route::get('recipe_reviews/page/{pagenum}/{itemsperpage}', 'API\V1\RecipeReviewController@index');
        
        Route::resource('meal', 'API\V1\MealController');
        Route::get('meals', 'API\V1\MealController@index');
        Route::get('meal/{id}/recipes', 'API\V1\MealController@recipes');
        Route::get('meal/{id}/tags', 'API\V1\MealController@tags');
        Route::get('meals/page/{pagenum}', 'API\V1\MealController@index');
        Route::get('meals/page/{pagenum}/{itemsperpage}', 'API\V1\MealController@index');

        Route::resource('event', 'API\V1\EventController');
        Route::get('events', 'API\V1\EventController@index');
        Route::get('event/{id}/attendees', 'API\V1\EventController@attendees');
        Route::get('event/{id}/tags', 'API\V1\EventController@tags');
        Route::get('events/page/{pagenum}', 'API\V1\EventController@index');
        Route::get('events/page/{pagenum}/{itemsperpage}', 'API\V1\EventController@index');

        Route::resource('todo', 'API\V1\TodoController');
        Route::get('todos', 'API\V1\TodoController@index');
        Route::get('todo/{id}/tags', 'API\V1\TodoController@tags');
        Route::get('todos/page/{pagenum}', 'API\V1\TodoController@index');
        Route::get('todos/page/{pagenum}/{itemsperpage}', 'API\V1\TodoController@index');

        Route::resource('document', 'API\V1\DocumentController');
        Route::get('documents', 'API\V1\DocumentController@index');
        Route::get('documents/page/{pagenum}', 'API\V1\DocumentController@index');
        Route::get('documents/page/{pagenum}/{itemsperpage}', 'API\V1\DocumentController@index');
        
        Route::resource('picture', 'API\V1\PictureController');
        Route::get('pictures', 'API\V1\PictureController@index');
        Route::get('pictures/page/{pagenum}', 'API\V1\PictureController@index');
        Route::get('pictures/page/{pagenum}/{itemsperpage}', 'API\V1\PictureController@index');
        
        Route::resource('notification', 'API\V1\NotificationController');
        Route::get('notifications', 'API\V1\NotificationController@index');
        Route::get('notification/tags', 'API\V1\NotificationController@tags');
        Route::get('notifications/page/{pagenum}', 'API\V1\NotificationController@index');
        Route::get('notifications/page/{pagenum}/{itemsperpage}', 'API\V1\NotificationController@index');

        Route::resource('product', 'API\V1\ProductController');
        Route::get('products', 'API\V1\ProductController@index');
        Route::get('products/page/{pagenum}', 'API\V1\ProductController@index');
        Route::get('products/page/{pagenum}/{itemsperpage}', 'API\V1\ProductController@index');
        
        Route::resource('invoice', 'API\V1\InvoiceController');
        Route::get('invoices', 'API\V1\InvoiceController@index');
        Route::get('invoices/page/{pagenum}', 'API\V1\InvoiceController@index');
        Route::get('invoices/page/{pagenum}/{itemsperpage}', 'API\V1\InvoiceController@index');
        
        Route::resource('ipn', 'API\V1\IPNController');
        Route::resource('membership', 'API\V1\MembershipController');

    }
);

Route::get('/', function()
{
	return View::make('hello');
});
Route::get('/api/v1', function(){
    return View::make('api');
});