angular.module('myApp')

    // shopping controller ------------------------------------------------------------------------------
    .controller('addUnitOfMeasureController',function($scope, $controller ,$http, Authenticate, UnitOfMeasures, Flash, $route, $modal){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // load all ingredients

        $scope.UnitOfMeasure = {};

        loadUnitOfMeasure();

        function loadUnitOfMeasure(){
            //load all categories.
            UnitOfMeasures.get()
                .success(function(data) {

                    $scope.TotalUnits =data.total_item;

                    $scope.TotalPages = data.total_page;

                    $scope.UnitsPerPage = data.items_per_page;

                    $scope.UnitOfMeasure = data.data;
            });
        }
        
        // ==============================================================================


        $scope.maxSize = 5;

        // this method called when page changes.

        $scope.getUnitspages = function(){

            if($scope.CurrentUnitsPage !== ''){

                UnitOfMeasures.getUnitsPerPage($scope.CurrentUnitsPage)
                    .success(function(data) {

                        $scope.UnitOfMeasure = data.data;

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

        $scope.Unit = {};

        $scope.Unit.name = '';

        $scope.Unit.alias = '';

        $scope.Unit.preferred_alias = '';

        $scope.addNewUnit = function (form) { 

                $scope.submitted = true;

                if(form.$valid) {
                    UnitOfMeasures.save($scope.Unit)
                        .success(function(response){

                            $scope.add_count = $scope.add_count + 1 ;

                            if($scope.add_count === 1 ){
                                $scope.add_uom = 'unit';
                            }
                            else{
                                $scope.add_uom = 'units';
                            }

                            $scope.sucess1 = true;

                            $scope.submitted = false;
                            
                            $scope.Unit.name = '';

                            $scope.Unit.alias = '';

                            $scope.Unit.preferred_alias = '';

                            loadUnitOfMeasure();
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
        
        $scope.delete = function (uom) {
            
            var id = uom.id;

            UnitOfMeasures.destroy(id)
               .success(function(response){
                    
                    $scope.delete_count = $scope.delete_count + 1 ;
                    
                    $scope.sucess = true;

                    if($scope.delete_count === 1 ){
                        $scope.delete_uom = 'unit';
                    }
                    else{
                        $scope.delete_uom = 'units';
                    }

                    loadUnitOfMeasure();
            });
        }

        // ==============================================================================

        $scope.editUnitOfMeasure = function(uom){


            var modalInstance = $modal.open({
                templateUrl: 'editUnitOfMeasuremodal.html',
                controller: editUnitOfMeasureCtrl,
                resolve: {
                    uom: function(){
                        return uom;
                    }
                }
            });

        };

        // ==============================================================================

        // delete category controller
        var editUnitOfMeasureCtrl = function ($scope, $modalInstance, uom) {

            $scope.data = uom;

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