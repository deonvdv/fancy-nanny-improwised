angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('recipesController',function($scope, $controller, $http, Households ){

        $controller('homeController', {$scope: $scope});

        // object to hold all the data for the recipes
        $scope.recipes = {};
        
        loadrecipes();

        function loadrecipes(){
            //Fetch all Recipes for LoggedIn user's household.
            Households.getRecipes(sessionStorage.householdId)
                .success(function(data) {
                    $scope.recipes = data.data;
                });
        }
    });