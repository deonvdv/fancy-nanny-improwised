angular.module('myApp')

    // login controller ------------------------------------------------------------------------------
    .controller('loginController',function($scope, $sanitize, $location, Authenticate, Flash){
        if (sessionStorage.authenticated){
            $location.path('/home');           
        }

        $scope.login = function(){
            Authenticate.save({
                'email': $sanitize($scope.email),
                'password': $sanitize($scope.password)
            },function(response) {
                $location.path('/home');
                Flash.clear();
                sessionStorage.authenticated = true;
                sessionStorage.loggedUser = response.user;
                sessionStorage.loggedUsername = response.user["name"];
                sessionStorage.loggedUserId = response.user["id"];
                sessionStorage.householdId = response.user["household_id"];
            },function(response){
                //Flash.show(response.flash)
            })
        }
    })

    // home controller ------------------------------------------------------------------------------
    .controller('homeController',function($scope, $location, $http, $anchorScroll, Authenticate, Users, Households, Messages, Todos, Flash){
        if (!sessionStorage.authenticated){
            $location.path('/')
            Flash.show("you should be authenticated to access this page");
        }

        // set username of logged in user
        $scope.username = sessionStorage.loggedUsername;

        // object to hold all the data for the household
        $scope.household = {};

        // object to hold all unread messages for the LoggedIn user
        $scope.messages = {};

        // object to hold events for the LoggedIn user
        $scope.events = {};

        // object to hold all the data for the todos assigned to LoggedInUser and uncomplete
        $scope.todos = {};

        // object to hold meals for the household
        $scope.meals = {};

        // object to hold emergency contacts
        $scope.emergencycontacts = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;
        
        // get household members
        // Households.getMembers(sessionStorage.householdId)
        //     .success(function(data) {
        //         $scope.members = data.data;
        //     });

        //get household information
       // Households.get(sessionStorage.householdId)
       //      .success(function(data) {
       //          $scope.members = data.data;
       //      });

        // get all the household first and bind it to the $scope.household object
        Households.get(sessionStorage.householdId)
            .success(function(data) {
                $scope.household = data.data;
                var emergencycontacts = JSON.parse(data.data.emergency_contacts);
                var contacts = Object.keys(emergencycontacts);
                for(var key in contacts){
                    var keyname = contacts[key];
                    var obj = emergencycontacts[keyname];
                    obj.relation = keyname;
                    $scope.emergencycontacts = emergencycontacts;
                }
                $scope.loading = false;
            });

        //Fetch all Today Meals for LoggedIn Household User.
        Households.getTodayMeals(sessionStorage.householdId)
            .success(function(data){
                $scope.meals = data.data;
            });

        //Fetch all Todos for LoggedIn user.
        Todos.get(sessionStorage.loggedUserId)
            .success(function(data) {
                $scope.todos = data.data;                        
            });        

        //Fetch all Unread messages for LoggedIn user.
        Messages.getUnread(sessionStorage.loggedUserId)
            .success(function(data) {
                $scope.messages = data.data;                        
            });

        //Fetch all events for LoggedIn user.
        Users.getUpcomingEvents(sessionStorage.loggedUserId)
            .success(function(data){
                $scope.events = data.data;
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
    
    // todo controller ------------------------------------------------------------------------------
    .controller('todoController',function($scope, $controller ,$location, $http, $route, Authenticate, Todos, Flash, Households){
       
        $controller('homeController', {$scope: $scope})

        // object to hold all the data for the assignedTo todos
        $scope.assignedToTodos = {};

        // object to hold all the data for the completed todos by LoggedInUser
        $scope.completedTodos = {};
        
        // loading variable to show the spinning loading icon
        $scope.loading = true;

        loadData();

        $scope.refresh = loadData();

        // ======================================================

        // hold household members
        $scope.members = {};

        // object holds all the propertics of add new todo from DOM
        $scope.SentTodo = {};

        // object holds assigned to id
        $scope.SentTodo.owner_id = sessionStorage.loggedUserId;

        // object that store logged in user id user id
        $scope.SentTodo.assigned_by = sessionStorage.loggedUserId;

        // object holds assigned to id
        $scope.SentTodo.assigned_to = '';

        // object that hold new todos title
        $scope.SentTodo.title = '';

        // stores description of Todo
        $scope.SentTodo.description = '';

        // stores description of Todo
        $scope.SentTodo.due_date = '';

        // store notifed person
        $scope.SentTodo.notify = '';

        // store time before the todo display to person
        $scope.SentTodo.minutes_before = '';

        // object holds that todo is completed or not
        $scope.SentTodo.is_complete = '';

        // ======================================================

        // get household members
        Households.getMembers(sessionStorage.householdId)
            .success(function(data) {
                $scope.members = data.data;
        });

        function loadData(){
            //Fetch all Todos for LoggedIn user.
            Todos.get(sessionStorage.loggedUserId)
                .success(function(data) {
                    $scope.todos = data.data;
            });

            Todos.getAssignedTo(sessionStorage.loggedUserId)
                .success(function(data) {
                    $scope.assignedToTodos = data.data;
            });

            Todos.getCompleted(sessionStorage.loggedUserId)
                .success(function(data) {
                    $scope.completedTodos = data.data;
            });            
        }

        // this method fires when new todo is added from DOM.
        $scope.SentTodos = function(){

            $scope.SentTodo.minutes_before = 5;
            $scope.SentTodo.is_complete = 0;

            //this method save new todo into the database
            Todos.save($scope.SentTodo)
                .success(function(response){
                    $scope.SentTodo = response.data;
                    $route.reload();
            });

        }

    })

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

        $scope.addNewMessage = function(){

            console.log($scope.addMessages);

            // Messages.save($scope.addMessages)
            //     .success(function(response){
            //         $scope.addMessages = response.data;
            //         $route.reload();
            // });

        }

    })

    // recipes controller ------------------------------------------------------------------------------
    .controller('recipesController',function($scope, $controller, $http, Households ){

        $controller('homeController', {$scope: $scope});

        // object to hold all the data for the recipes
        $scope.recipes = {};
        
        loadrecipes();

        function loadrecipes(){
            //Fetch all Recipes for LoggedIn user's household.
            Households.getRecipes(sessionStorage.householdId)
                .success(function(data) {
                    $scope.recipes = data.data;
                });
        }
    })

     // tags controller ------------------------------------------------------------------------------
    .controller('tagsController',function($scope, $modal, $controller, $route, $templateCache, $http,  Users, Tags, Flash){

        $controller('homeController', {$scope: $scope});
       
        $scope.data = {};


        // object to hold all tags of LoggedInUser
        $scope.data.tags = {};
        $scope.data.name = "";
        $scope.data.color = "";
        $scope.data.fontcolor = "";

        loadData();

        function loadData(){
            //Fetch all tags for LoggedInUser
            Users.getTags(sessionStorage.loggedUserId)
                .success(function(data){
                    $scope.data.tags = data.data;
            });
        }

        // edit tag method of modal
        $scope.editTag = function(tag) {
            var modalInstance = $modal.open({
                templateUrl: 'editTagmodal.html',
                controller: editTagCtrl,
                resolve: {
                    tag: function() {
                        return tag;
                    }
                }
            });

        }

        // edit tag controller
        var editTagCtrl = function ($scope, $modalInstance, tag) {


            $scope.title = "Edit";

            if(tag === undefined) {
                tag = {};
                $scope.title = "Add";
            } else {
                Tags.show(tag.id)
                    .success(function(response){
                        tag = response.data;
                    });
            }

            $scope.options = [
                { label: 'White', value: 'white' },
                { label: 'Black', value: 'black' }
            ];


            $scope.data = tag;
            $scope.data.owner_id = sessionStorage.loggedUserId;
            $scope.data.fontcolorOption = $scope.options[1];

            $scope.save = function (form) {

                // bind fontcolorOption to fontcolor
                $scope.data.fontcolor = $scope.data.fontcolorOption.value;

                $scope.submitted = true;
                if(form.$valid) {
                    Tags.save($scope.data)
                        .success(function(response){
                            $modalInstance.close($scope.data.tag);
                            $route.reload();
                    });
                }
            };

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };

        };

        // delete tag method of modal
        $scope.deleteTag = function(tag) {

            var modalInstance = $modal.open({
                templateUrl: 'delete.html',
                controller: deleteTagCtrl,
                resolve: {
                    tag: function(){
                        return tag;
                    }
                }
            });

        }

        // delete tag controller
        var deleteTagCtrl = function ($scope, $modalInstance, tag) {

            $scope.data = tag;

            $scope.delete = function () {
                Tags.destroy($scope.data.id)
                    .success(function(response){
                        $modalInstance.close($scope.data);
                        $route.reload();
                    });
            }

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };
        };

    })

    // document controller ------------------------------------------------------------------------------
    .controller('documentsController',function($scope, $controller ,$http ){

        $controller('homeController', {$scope: $scope});



    })

    // shopping controller ------------------------------------------------------------------------------
    .controller('shoppingController',function($scope, $controller ,$http, Authenticate, Todos, Flash){

        $controller('homeController', {$scope: $scope});

    })

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

    })

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

    })

    // calender controller ------------------------------------------------------------------------------
    .controller('calenderController',function($scope, $controller ,$http ){

        $controller('homeController', {$scope: $scope});

    })

    // event controller ------------------------------------------------------------------------------
    .controller('eventsController',function($scope, $controller ,$http ){

        $controller('homeController', {$scope: $scope});

    });