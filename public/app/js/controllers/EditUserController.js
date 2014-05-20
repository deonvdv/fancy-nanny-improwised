angular.module('myApp')

    // edit user controller ------------------------------------------------------------------------------
    .controller('editUserController',function($scope, $modal, $controller, $http, Users, $route, $location){

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

        $scope.save = function(form){

            $scope.submitted = true;
            if(form.$valid) {
                //save user information for LoggedInUser
                Users.save($scope.user)
                    .success(function(response){
                        $scope.user = response.data;
                });
                $location.path('/user_profile');
            }

        }

        $scope.cancel = function(){
            $location.path('/user_profile');
        }


        // edit password method
        $scope.changePassword = function(user) {
            var modalInstance = $modal.open({
                templateUrl: 'changepassword.html',
                controller: changePasswordCtrl,
                resolve: {
                    user: function() {
                        return user;
                    }
                }
            });

        }

        // user's edit-password controller
        var changePasswordCtrl = function ($scope, $modalInstance, user) {

                $scope.user = user;

                $scope.user.oldpassword = '';

                $scope.save = function(form){

                    $scope.submitted = true;
                    if(form.$valid) {
                        //save user information for LoggedInUser
                        Users.save($scope.user)
                            .success(function(response){
                                $modalInstance.close($scope.data);
                                // $scope.user.password = response.data;
                        });
                        $location.path('/user_profile');
                    }

                }

                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                    $location.path('/user_profile');
                };

        };

    });