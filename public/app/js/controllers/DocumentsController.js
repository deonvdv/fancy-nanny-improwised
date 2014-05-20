angular.module('myApp')

    // document controller ------------------------------------------------------------------------------
    .controller('documentsController',function($scope, $controller ,$http ){

        $controller('homeController', {$scope: $scope});

    });