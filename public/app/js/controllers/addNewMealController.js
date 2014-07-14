angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('addNewMealController',function($scope, $controller, $http, Recipes, Meals, $timeout){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // array stroes weekly meal list
        $scope.Weekly_Meal = [];

        loadmeals();

        //Fetch all meals for LoggedIn user's household.
        function loadmeals(){
            $scope.Weekly_Meal = Meals.get();
            console.log($scope.Weekly_Meal);
        }

        // ==============================================================================

        // object to hold all the data for the recipes

        $scope.recipes = {};

        loadrecipes();

        //Fetch all Recipes for LoggedIn user's household.
        function loadrecipes(){
            Recipes.get()
                .success(function(data) {
                    $scope.recipes = data.data;
            });
        }

        // ==============================================================================

        $scope.Slotes = ["Breakfast","Lunch","Dinner"];

        $scope.Days = [ 

                        {id:"1",name:"Sunday"},
                        {id:"2",name:"Monday"},
                        {id:"3",name:"Tuesday"},
                        {id:"4",name:"Wednesday"},
                        {id:"5",name:"Thursday"},
                        {id:"6",name:"Friday"},
                        {id:"7",name:"Saturday"}

                      ];  

        // ==============================================================================

        $scope.select2Options = {
            allowClear:true
        };

        // ==============================================================================

        function new_recipe(){
            var new_Recipe = {};
            new_Recipe.recipe_id = '';
            return new_Recipe;
        }

        // ==============================================================================

        $scope.addNewMealRecipe = function(){
            $scope.new_meal.recipes.push(new_recipe());
        };

        // ==============================================================================

        $scope.loadMeal = function (){
            $scope.new_meal = {};
            $scope.new_meal.household_id = sessionStorage.householdId;
            $scope.new_meal.day_of_week = '';
            $scope.new_meal.slot = '';
            $scope.new_meal.week_number = 1;
            $scope.new_meal.recipes = [];
            $scope.addNewMealRecipe();
            $scope.submitted = false;
            $scope.error_msg = false;
        }

        $scope.loadMeal();

        // ==============================================================================

        $scope.removeMealRecipe = function(recipe){
            $scope.new_meal.recipes.pop(recipe);
        };

        // ==============================================================================

        $scope.sucessMealAdd = false;

        $scope.doneMealAdd = function(){
            $timeout(function () { $scope.sucessMealAdd = false; }, 5000);
        };

        // ==============================================================================

        // add meal to database

        $scope.addMeal = function (form){

            $scope.submitted = true;

            if( $scope.new_meal.recipes.length === 1 && form.$valid ){

                $scope.doneMealAdd();

                Meals.save($scope.new_meal)
                    .success(function(response){
                       $scope.loadMeal();
                       loadmeals();
                       $scope.submitted = false;
                       $scope.sucessMealAdd = true;
                       $scope.doneMealAdd();
                });

            }

            else if( $scope.new_meal.recipes.length > 1 && form.$valid ){

                for(var outer_recipe = 0 ; outer_recipe < $scope.new_meal.recipes.length-1 ; outer_recipe++){

                    for( var inner_recipe = 1 ;  inner_recipe < $scope.new_meal.recipes.length ; inner_recipe++) {

                        if( $scope.new_meal.recipes[outer_recipe].recipe_id === $scope.new_meal.recipes[inner_recipe].recipe_id ) {

                            console.log("hi inner");
                            $scope.error_msg_dups = true;
                            form.valid = false;
                            break;


                        }
                        else if( $scope.new_meal.recipes[outer_recipe].recipe_id !== $scope.new_meal.recipes[inner_recipe].recipe_id  ) {

                            $scope.error_msg_dups = false;
                            console.log("hi inner aaa");
                            break;

                        }

                    }


                }

            }

            else{

                console.log( "form added" );

            }

            // else (  )


            // if(  )


            // if(form.$valid && $scope.new_meal.recipes.length !== 0) {

            //     $scope.sucessMealAdd = true;

            //     $scope.doneMealAdd();

            //     Meals.save($scope.new_meal)
            //         .success(function(response){
            //            $scope.loadMeal();
            //            loadmeals();
            //            $scope.submitted = false;
            //     });

            // }

            // else if($scope.new_meal.recipes.length === 0){
            //     $scope.error_msg = true;
            // }

        };


        $scope.rec = function(){

            if( $scope.new_meal.recipes.length > 1 ){

                console.log("hi");

            }

        };


        // ==============================================================================

        $scope.delete_recipe = function(recipe){
            recipe.hover_recipe = true;
            $scope.active_recipe(recipe);
        };

        $scope.active_recipe = function(recipe){
            $timeout(function () { recipe.hover_recipe = false; }, 5000);
        };

        // ==============================================================================

        $scope.dropmeal = false;

        $scope.dropMeal = function(){
            $timeout(function () { $scope.dropmeal = false; }, 5000);
        };

        // ==============================================================================

        // this method delete meal from schedule.
        $scope.delete_meal_recipe = function(day1){

            Meals.destroy(day1.id)
                .success(function(response){
                   $scope.dropmeal = true;
                   $scope.dropMeal();
                   loadmeals();
            });

        }

        // ==============================================================================

    });