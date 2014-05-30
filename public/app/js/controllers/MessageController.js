angular.module('myApp')

    // message controller ------------------------------------------------------------------------------
    .controller('messageController',function($scope, $controller, $http, Messages, $route, Households){
       
        $controller('homeController', {$scope: $scope})

        // object to hold all the data for the ReceivedMessages
        $scope.receivedMessages = {};

        // object to hold all the data for the SentMessages
        $scope.sentMessages = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        loadData();

        // =======================================================

        // hold household members
        $scope.members = {};

        // object that holds add messages propertics
        $scope.addMessages = {};

        // logged in user id
        $scope.addMessages.sender_id = sessionStorage.loggedUserId;

        // stores receiver id.
        $scope.addMessages.receiver_id = [];

        // stores description of message
        $scope.addMessages.message = '';

        // ========================================================

        // get household members
        Households.getMembers(sessionStorage.householdId)
            .success(function(data) {
                $scope.members = data.data;
        });

        function loadData(){
            //Fetch all ReceivedMessages for LoggedIn user.
            Messages.getReceived(sessionStorage.loggedUserId)
                .success(function(data) {
                    $scope.receivedMessages = data.data;
            });

            //Fetch all SentMessages for LoggedIn user.
            Messages.getSent(sessionStorage.loggedUserId)
                .success(function(data) {
                    $scope.sentMessages = data.data;
            });
        }

        $scope.addNewMessage = function(form){

            $scope.submitted = true;

            if(form.$valid) {

                Messages.save($scope.addMessages)
                    .success(function(response){
                        $scope.addMessages = response.data;
                        $route.reload();
                });

            }

        }

        // ==============================================================================

        // make message read

        $scope.msgRead = function(message){

            message.is_read = 1;

            // method that save the status of todo in database (  incomplete to complete  )

                // here

        }



    });