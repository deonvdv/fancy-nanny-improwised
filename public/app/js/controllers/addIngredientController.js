angular.module('myApp')

    // shopping controller ------------------------------------------------------------------------------
    .controller('addIngredientController',function($scope, $controller ,$http, Authenticate, Ingredients, Flash, $route, $modal){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // load all ingredients

        $scope.Ingredient = {};

        loadIng();

        function loadIng(){
            //Fetch all Recipes for LoggedIn user's household.
            Ingredients.get()
                .success(function(data) {
                    $scope.Ingredient = data.data;
            });
        }

        // ==============================================================================

        // save ingredient

        $scope.Ing = {};

        $scope.Ing.name = '';

        $scope.addNewIng = function (form) { 

                $scope.submitted = true;

                if(form.$valid) {
                    Ingredients.save($scope.Ing)
                        .success(function(response){
                            $route.reload();
                    });
                }
        };

        // ==============================================================================

        $scope.sucess = false;

        $scope.done = function(){
            $scope.sucess = false;
        };

        // ==============================================================================

        // destroy ingredient

        $scope.delete = function (ing) {
        	var id = ing.id;
            Ingredients.destroy(id)
               .success(function(response){
               		$scope.sucess = true;
                 	console.log(id + "delete");
                	loadIng();
            });
        }

        // ==============================================================================

        $scope.editIng = function(ing){


        	var modalInstance = $modal.open({
                templateUrl: 'editIngredientmodal.html',
                controller: editIngCtrl,
                resolve: {
                    ing: function(){
                        return ing;
                    }
                }
            });

        };

        // ==============================================================================

        // delete tag controller
        var editIngCtrl = function ($scope, $modalInstance, ing) {

            $scope.data = ing;

            $scope.save = function (form) {

                $scope.submitted = true;

                if(form.$valid) {

                	console.log("done");

                    // Tags.save($scope.data)
                    //     .success(function(response){
                    //         $modalInstance.close($scope.data.tag);
                    //         $route.reload();
                    // });

                }

            };

             $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };
           
        };

        // ==============================================================================

    });