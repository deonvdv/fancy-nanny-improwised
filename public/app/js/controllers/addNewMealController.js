angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('addNewMealController',function($scope, $controller, $http, Recipes, Meals, $timeout){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        $scope.day_of_week = [];

        loadmeals();

        //Fetch all meals for LoggedIn user's household.
        function loadmeals(){
            $scope.day_of_week = Meals.get();
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
            $scope.meal_array.recipe_id.push(new_recipe());
        };

        // ==============================================================================

        $scope.loadMeal = function (){
            $scope.meal_array = [];
            $scope.meal_array.household_id = sessionStorage.householdId;
            $scope.meal_array.day_of_week = '';
            $scope.meal_array.slot = '';
            $scope.meal_array.recipe_id = [];
            $scope.addNewMealRecipe();
            $scope.submitted = false;
            $scope.error_msg = false;
        }

        $scope.loadMeal();

        // ==============================================================================

        $scope.removeMealRecipe = function(recipe){
            $scope.meal_array.recipe_id.pop(recipe);
        };

        // ==============================================================================

        $scope.sucessTagAdd = false;

        $scope.doneTagAdd = function(){
            $timeout(function () { $scope.sucessTagAdd = false; }, 3000);
        };

        // ==============================================================================

        // add meal to database

        $scope.addMeal = function (form){

            $scope.submitted = true;

            if(form.$valid && $scope.meal_array.recipe_id.length !== 0) {

                console.log("done");

                console.log($scope.meal_array);

                $scope.sucessTagAdd = true;

                $scope.doneTagAdd();

                // Meals.save($scope.meal_array)
                //     .success(function(response){                     
                //        loadMeal();
                //        $scope.init();
                //        $scope.submitted = false;
                // });

            }

            else if($scope.meal_array.recipe_id.length === 0){
                $scope.error_msg = true;
            }

        };

        // ==============================================================================

    });