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

                    $scope.TotalCategories =data.total_item;

                    $scope.TotalPages = data.total_page;

                    $scope.CategoriesPerPage = data.items_per_page;

                    $scope.category = data.data;
            });
        }
        
        // ==============================================================================

         $scope.maxSize = 5;

        // this method called when page changes.

        $scope.getCategoriespages = function(){

            if($scope.CurrentCategoriesPage !== ''){

                Categories.getCategoriesPerPage($scope.CurrentCategoriesPage)
                    .success(function(data) {

                        $scope.category = data.data;

                });

            }

        }

        // ==============================================================================

        $scope.add_count = 0;

        $scope.sucess1 = false;

        $scope.done1 = function(){
            $scope.sucess1 = false;
        };

        // ==============================================================================

        // save categories

        $scope.Cat = {};

        $scope.Cat.name = '';

        $scope.addNewCat = function (form) { 

                $scope.submitted = true;

                if(form.$valid) {
                    Categories.save($scope.Cat)
                        .success(function(response){

                            $scope.add_count = $scope.add_count + 1 ;

                            if($scope.add_count === 1 ){
                                $scope.add_cat = 'category';
                            }
                            else{
                                $scope.add_cat = 'categories';
                            }

                            $scope.sucess1 = true;

                            $scope.submitted = false;

                            $scope.Cat.name = '';

                            loadCategory();

                    });
                }
        };

        // ==============================================================================

        $scope.delete_count = 0;

        $scope.sucess = false;

        $scope.done = function(){
            $scope.sucess = false;
        };

        // ==============================================================================

        // destroy category

        $scope.delete = function (cat) {
            
            var id = cat.id;

            Categories.destroy(id)
               .success(function(response){
                    
                    $scope.delete_count = $scope.delete_count + 1 ;
                    
                    $scope.sucess = true;

                    if($scope.delete_count === 1 ){
                        $scope.delete_cat = 'category';
                    }
                    else{
                        $scope.delete_cat = 'categories';
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