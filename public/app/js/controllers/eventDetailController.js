angular.module('myApp')

    // event Detail controller ------------------------------------------------------------------------------
    .controller('eventDetailController',function($scope, $controller ,$http ,Events , $routeParams ){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // event detail for perticuler event ( for page --> eventdetail.html )

        $scope.eventDetail = {};

        $scope.eventDetail = function() {

            // load event using route params(event id)
            Events.show($routeParams.eventId)
                .success(function(response){
                    $scope.eventDetail = response.data;
                    console.log($scope.eventDetail);
            });

        };

    });