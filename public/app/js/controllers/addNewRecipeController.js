angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('addNewRecipeController',function($scope, $controller, $http, Ingredients, Categories, UnitOfMeasures, Recipes, $route){

        $controller('homeController', {$scope: $scope});

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

        // sucess notification

        $scope.sucess = false;

        $scope.done = function(){
            $scope.sucess = false;
        };

        // ==============================================================================

        // add Recipe to database

        $scope.addRecipe = function (form){

            $scope.submitted = true;

            if(form.$valid && $scope.addNewRecipe.newIngredients.length !== 0) {

                Recipes.save($scope.addNewRecipe)
                    .success(function(response){
                        $scope.sucess = true;
                        $scope.submitted = false;
                        loadNewRecipe();
                        $scope.init();
                });

            }

            else{
                $scope.error_msg = true;
            }

        };

        // ==============================================================================

    });