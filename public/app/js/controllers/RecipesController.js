angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('recipesController',function($scope, $controller, $http, $routeParams, Recipes, $route, Users){

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
            Recipes.get()
                .success(function(data) {
                    $scope.recipes = data.data;
            });
        }

        // ==============================================================================

        // make recipe favorite ( for page --> recipes.html )

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