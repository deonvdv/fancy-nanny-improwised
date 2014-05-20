angular.module('myApp')

    // event controller ------------------------------------------------------------------------------
    .controller('eventsController',function($scope, $controller ,$http ){

        $controller('homeController', {$scope: $scope});

    });