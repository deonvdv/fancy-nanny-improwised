angular.module('myApp')

    // event controller ------------------------------------------------------------------------------
    .controller('eventsController',function($scope, $controller, $http, Events, $modal, $templateCache, $route,Flash){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // object to hold all the data for events

        $scope.events = {};

        loadEvents();

        function loadEvents(){
            //Fetch all Fevorite Recipes for LoggedIn User.
            Events.get()
                .success(function(data) {

                    $scope.Totalevents =data.total_item;

                    $scope.TotalPages = data.total_page;

                    $scope.eventsPerPage = data.items_per_page;

                    $scope.events = data.data;
            });
        }

        // ==============================================================================

        $scope.maxSize = 5;

        // this method called when page changes.

        $scope.geteventspages = function(){

            if($scope.CurrenteventsPage !== ''){

                Events.geteventsPerPage($scope.CurrenteventsPage)
                    .success(function(data) {

                        $scope.events = data.data;

                });

            }

        }

        // ==============================================================================

        // add-edit Event method of modal
        $scope.addeditEvent = function(event){

            var modalInstance = $modal.open({
                templateUrl: 'addediteventmodal.html',
                controller: editEventCtrl,
                resolve: {
                    event: function() {
                        return event;
                    }
                }
            });

        }

        // ==============================================================================

        // add-edit event controller
        var editEventCtrl = function ($scope, $modalInstance, event) {

            if( event === undefined ){

                $scope.title = "Add";
                $scope.data = {};

            }
            else{

                $scope.title = "Edit";
                $scope.data = event;

            }

            $scope.eventPeriod = [{number:1,add_day:"yes"},{number:0,add_day:"No"}];

            $scope.eventTypes = ["birthday","meeting","dinner","call","travel"];

            $scope.data.owner_id = sessionStorage.loggedUserId;

            $scope.save = function (form) {

                $scope.submitted = true;

                if(form.$valid) {
                    Events.save($scope.data)
                        .success(function(response){
                            $modalInstance.close();
                            $route.reload();
                    });
                }
            };

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };

        };

        // ==============================================================================

        // delete event method of modal
        $scope.deleteEvent = function(event) {

            var modalInstance = $modal.open({
                templateUrl: 'delete.html',
                controller: deleteEventCtrl,
                resolve: {
                    event: function(){
                        return event;
                    }
                }
            });

        }

        // delete event controller
        var deleteEventCtrl = function ($scope, $modalInstance, event) {

            $scope.data = event;

            $scope.delete = function () {
                Events.destroy($scope.data.id)
                    .success(function(response){
                        $modalInstance.close();
                        $route.reload();
                    });
            }

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };
        };

    });