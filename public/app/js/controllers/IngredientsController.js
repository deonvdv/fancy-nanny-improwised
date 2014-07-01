angular.module('myApp')

    // shopping controller ------------------------------------------------------------------------------
    .controller('IngredientsController',function($scope, $controller ,$http, Authenticate, Ingredients, Flash, $route, $modal, $timeout){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // load all ingredients

        $scope.Ingredient = {};

        loadIng();

        function loadIng(){
            //loads all ingredients.
            Ingredients.get()
                .success(function(data) {

                    $scope.TotalIngredients =data.total_item;

                    $scope.TotalPages = data.total_page;

                    $scope.IngredientsPerPage = data.items_per_page;

                    $scope.Ingredient = data.data;

                    console.log($scope.Ingredient);

            });
        }

        // ==============================================================================

        $scope.maxSize = 5;

        // this method called when page changes.

        $scope.getIngredientspages = function(){

            if($scope.CurrentIngredientsPage !== ''){

                Ingredients.getIngredientsPerPage($scope.CurrentIngredientsPage)
                    .success(function(data) {

                        $scope.Ingredient = data.data;

                });

            }

        }

        // ==============================================================================

        $scope.add_count = 0;

        $scope.sucess1 = false;

        $scope.done1 = function(){
            $timeout(function () { $scope.sucess1 = false; }, 3000);
        };

        // ==============================================================================

        // save ingredient

        $scope.Ing = {};

        $scope.Ing.name = '';

        $scope.addNewIng = function (form) { 

                $scope.submitted = true;

                $scope.sucess1 = true;

                $scope.done1();

                if(form.$valid) {
                    Ingredients.save($scope.Ing)
                        .success(function(response){

                            $scope.add_count = $scope.add_count + 1 ;

                            if($scope.add_count === 1 ){
                                $scope.add_ing = 'ingredient';
                            }
                            else{
                                $scope.add_ing = 'ingredients';
                            }

                            $scope.sucess1 = true;

                            $scope.submitted = false;

                            $scope.Ing.name = '';

                            loadIng();

                    });
                }
        };

        // ==============================================================================

        $scope.delete_count = 0;

        $scope.sucess = false;

        $scope.done = function(){
            $timeout(function () { $scope.sucess = false; }, 3000);
        };

        // ==============================================================================

        // destroy ingredient

        $scope.count = 0;

        $scope.delete = function (ing) {

            var id = ing.id;

            $scope.sucess = true;

            $scope.done();

            Ingredients.destroy(id)
               .success(function(response){

                    $scope.delete_count = $scope.delete_count + 1 ;

                    $scope.sucess = true;

                    if($scope.delete_count === 1 ){
                        $scope.delete_ing = 'unit';
                    }
                    else{
                        $scope.delete_ing = 'units';
                    }

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

        // delete ingredient controller

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