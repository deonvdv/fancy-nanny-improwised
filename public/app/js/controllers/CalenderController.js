angular.module('myApp')

    // calender controller ------------------------------------------------------------------------------
    .controller('calenderController',function($scope, $controller ,$http ){

        $controller('homeController', {$scope: $scope});

    });