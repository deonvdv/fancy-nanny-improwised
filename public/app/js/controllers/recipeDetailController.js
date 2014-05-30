angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('recipeDetailController',function($scope, $http, $controller, $routeParams, Recipes){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // recipe detail for perticuler recipe ( for page --> recipedetail.html )

        $scope.recipeDetail = {};

        $scope.recipeDetail = function() {

            // load recpie using route params(recipe id)
            Recipes.show($routeParams.recipeId)
                .success(function(response){
                    $scope.recipeDetail = response.data;
            });

        };

        // ==============================================================================

    });