angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('recipesController',function($scope, $controller, $http, Households, Ingredients, Categories, UnitOfMeasures, Recipes, RecipeIngredients, $route, Users){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // object to hold all the data for the favorite recipes

        $scope.favoriterecipe = [];

        loadfavoriterecipe();

        function loadfavoriterecipe(){
            //Fetch all Fevorite Recipes for LoggedIn User.
            Users.getFavoriteRecipes(sessionStorage.loggedUserId)
                .success(function(data) {
                    $scope.favoriterecipe = data.data;
            });
        }

        // ==============================================================================

        // object to hold all the data for the recipes

        $scope.recipes = {};

        $scope.recipes.fav = "favoriterecipedone";

        loadrecipes();

        function loadrecipes(){
            //Fetch all Recipes for LoggedIn user's household.
            Households.getRecipes(sessionStorage.householdId)
                .success(function(data) {
                    $scope.recipes = data.data;
            });
        }

        // ==============================================================================

        function loadNewRecipe(){

            // objects stores information in Recipes table of database

            $scope.addNewRecipe = {};

            $scope.addNewRecipe.author_id = sessionStorage.loggedUserId;

            $scope.addNewRecipe.name = '';

            $scope.addNewRecipe.description = '';

            $scope.addNewRecipe.instructions = '';

            $scope.addNewRecipe.number_of_portions = '';

            $scope.addNewRecipe.preparation_time = '';

            $scope.addNewRecipe.cooking_time = '';

            $scope.addNewRecipe.category_id = '';

            // objects stores information in Recipes_ingredients table of database

            $scope.addNewRecipe.newIngredients = [];

        }

        loadNewRecipe();

        // ==============================================================================

        function addIngredient(){

            var ingredient = {};

            ingredient.recipe_id = '';

            ingredient.Ing_id = $scope.addNewRecipe.newIngredients.length + 1;

            ingredient.quantity = '';

            ingredient.unit_of_measure_id = '';

            ingredient.ingredient_id = '';

            return ingredient;

        }

        // ==============================================================================

        $scope.init = function() {

            for(i=0;i<5;i++){

                $scope.addNewRecipe.newIngredients.push(addIngredient());

            }

        };

        $scope.init();

        // ==============================================================================

        // add new ingredient to recipe

        $scope.addNewItem = function(){

            $scope.addNewRecipe.newIngredients.push(addIngredient());

        };

        // ==============================================================================

        // remove ingredient to recipe

        $scope.removeIngredient = function(ingredient){

            $scope.addNewRecipe.newIngredients.pop(ingredient);

        };

        // ==============================================================================

        // load Ingredients

        $scope.Ingredients = {};

        loadIngredients();

        function loadIngredients(){

            Ingredients.get(sessionStorage.loggedUserId)
                .success(function(data){
                    $scope.Ingredients = data.data;
            });

        }

        // ==============================================================================

        // load Categories

        $scope.Categories = {};

        $scope.Categories.id = '';

        $scope.Categories.name = '';

        loadCategories();

        function loadCategories(){

            Categories.get(sessionStorage.loggedUserId)
                .success(function(data){
                    $scope.Categories = data.data;
            });

        }

        // ==============================================================================

        // load Unit Of Measures

        $scope.UnitOfMeasures = {};

        loadUnitOfMeasure();

        function loadUnitOfMeasure(){

            UnitOfMeasures.get()
                .success(function(data){
                    $scope.UnitOfMeasures = data.data;
            });

        }

        // ==============================================================================

        $scope.sucess = false;

        $scope.done = function(){
            $scope.sucess = false;
        };

        // ==============================================================================

        // add Recipe to database

        $scope.addRecipe = function (form){

            $scope.submitted = true;

            if(form.$valid) {

                Recipes.save($scope.addNewRecipe)
                    .success(function(response){
                        $scope.sucess = true;
                        $scope.submitted = false;
                        loadNewRecipe();
                        $scope.init();
                });

            }

        };

        // ==============================================================================

        $scope.favRecipe = {};

        $scope.favRecipe.recipe_id = "";

        $scope.favRecipe.user_id = sessionStorage.loggedUserId;

        $scope.makeFavorite = function (recipe) {

            $scope.favRecipe.recipe_id = recipe.id;

            if(recipe.fav !== "favoriterecipedone"){

                recipe.fav = "favoriterecipedone";

                // Users.save($scope.favRecipe)
                //     .success(function(response){
                //         $scope.favRecipe = response.data;
                // });
            }

        };

        $scope.initFav = function(recipe){

            for( i=0 ; i < $scope.favoriterecipe.length ; i++){

                if ($scope.favoriterecipe[i].id === recipe.id){

                    recipe.fav = "favoriterecipedone";
                    break;

                }

            }

        };

        // ==============================================================================

    });