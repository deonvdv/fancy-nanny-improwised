angular.module('myApp')

    // event controller ------------------------------------------------------------------------------
    .controller('eventsController',function($scope, $controller ,$http ,Events){

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

    });