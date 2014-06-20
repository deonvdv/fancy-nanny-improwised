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
            $scope.new_meal.recipe_id.pop(recipe);
        };

        // ==============================================================================

        $scope.sucessMealAdd = false;

        $scope.doneMealAdd = function(){
            $timeout(function () { $scope.sucessMealAdd = false; }, 3000);
        };

        // ==============================================================================

        // add meal to database

        $scope.addMeal = function (form){

            $scope.submitted = true;

            if(form.$valid && $scope.new_meal.recipes.length !== 0) {

                $scope.sucessMealAdd = true;

                $scope.doneMealAdd();

                Meals.save($scope.new_meal)
                    .success(function(response){
                       $scope.loadMeal();
                       loadmeals();
                       $scope.submitted = false;
                });

            }

            else if($scope.new_meal.recipes.length === 0){
                $scope.error_msg = true;
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

    });