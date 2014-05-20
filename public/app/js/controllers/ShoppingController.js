angular.module('myApp')

    // shopping controller ------------------------------------------------------------------------------
    .controller('shoppingController',function($scope, $controller ,$http, Authenticate, Todos, Flash){

        $controller('homeController', {$scope: $scope});

    });