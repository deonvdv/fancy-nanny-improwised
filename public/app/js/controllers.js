angular.module('myApp')
    .controller('loginController',function($scope,$sanitize,$location,Authenticate,Flash){
        if (sessionStorage.authenticated){
            $location.path('/home');           
        }

        $scope.login = function(){
            Authenticate.save({
                'email': $sanitize($scope.email),
                'password': $sanitize($scope.password)
            },function() {
                $location.path('/home')
                Flash.clear()
                sessionStorage.authenticated = true;
            },function(response){
                //Flash.show(response.flash)
            })
        }
    })

    .controller('homeController',function($scope,$location, $http, Authenticate, Households, Flash){
        if (!sessionStorage.authenticated){
            $location.path('/')
            Flash.show("you should be authenticated to access this page");
        }

         // object to hold all the data for the households
        $scope.households = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;
        
        // get all the household first and bind it to the $scope.households object
        Households.get()
            .success(function(data) {
                $scope.households = data.data;
                
                for(var i = 0; i < $scope.households.length; i ++) {
                    console.log($scope.households[i].id);
                    $scope.households[i].messages = {};
                    Households.getMessages($scope.households[i].id)
                        .success(function (data) {
                            $scope.households[i].messages = data.data;
                        });
                }
                $scope.loading = false;
            });
       
        $scope.logout = function (){
            Authenticate.get({},function(response){
                delete sessionStorage.authenticated;
                Flash.show(response.flash);
                $location.path('/');
            })
        }

        // function to handle deleting a household
        $scope.deleteHousehold = function(id) {

            Authenticate.get({}, function(response){
                $scope.loading = true; 

            Households.destroy(id)
                .success(function(data) {

                    // if successful, we'll need to refresh the household list
                    Households.get()
                        .success(function(getData) {
                            $scope.households = getData.data;
                            $scope.loading = false;
                        });
                     $location.path('/')
                });
            });
        };
    })