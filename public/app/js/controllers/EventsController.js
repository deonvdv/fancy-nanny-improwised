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
                    $scope.events = data.data;
            });
        }

        // ==============================================================================

    });