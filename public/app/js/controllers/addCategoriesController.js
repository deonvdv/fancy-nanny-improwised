angular.module('myApp')

    // shopping controller ------------------------------------------------------------------------------
    .controller('addCategoriesController',function($scope, $controller ,$http, Authenticate, Categories, Flash, $route, $modal){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // load all ingredients

        $scope.category = {};

        loadCategory();

        function loadCategory(){
            //load all categories.
            Categories.get()
                .success(function(data) {
                    $scope.category = data.data;
            });
        }
        
        // ==============================================================================

        // save categories

        $scope.Cat = {};

        $scope.Cat.name = '';

        $scope.addNewCat = function (form) { 

                $scope.submitted = true;

                if(form.$valid) {
                    Categories.save($scope.Cat)
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

        // destroy category
        $scope.count = 0;

        $scope.delete = function (cat) {
            
            var id = cat.id;

            Categories.destroy(id)
               .success(function(response){
                    
                    $scope.count = $scope.count + 1 ;
                    
                    $scope.sucess = true;

                    if($scope.count === 1 ){
                        $scope.cat = 'category';
                    }
                    else{
                        $scope.cat = 'categories';
                    }

                    loadCategory();
            });
        }

        // ==============================================================================

        $scope.editCat = function(cat){


            var modalInstance = $modal.open({
                templateUrl: 'editCategorymodal.html',
                controller: editCatCtrl,
                resolve: {
                    cat: function(){
                        return cat;
                    }
                }
            });

        };

        // ==============================================================================

        // delete category controller
        var editCatCtrl = function ($scope, $modalInstance, cat) {

            $scope.data = cat;

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