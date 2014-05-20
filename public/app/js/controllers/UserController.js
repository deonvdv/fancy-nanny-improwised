angular.module('myApp')

    // user controller ------------------------------------------------------------------------------
    .controller('userController',function($scope, $controller ,$http ,Users ,$route ){

        $controller('homeController', {$scope: $scope});

        $scope.user = {};

        loadData();

        function loadData(){
            //Fetch user information for LoggedInUser
            Users.show(sessionStorage.loggedUserId)
                .success(function(data){
                    $scope.user = data.data;
            });
        }

    });