angular.module('myApp')
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
    
    .controller('todoController',function($scope, $controller ,$location, $http, Authenticate, Todos, Flash){
       
        $controller('homeController', {$scope: $scope})

        // object to hold all the data for the assignedTo todos
        $scope.assignedToTodos = {};

        // object to hold all the data for the completed todos by LoggedInUser
        $scope.completedTodos = {};
        
        // loading variable to show the spinning loading icon
        $scope.loading = true;

        loadData();
            
        $scope.refresh = loadData();

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
    })

    .controller('messageController',function($scope, $controller ,$location, $http, Authenticate, Messages, Flash){
       
        $controller('homeController', {$scope: $scope})

        // object to hold all the data for the ReceivedMessages
        $scope.receivedMessages = {};

        // object to hold all the data for the SentMessages
        $scope.sentMessages = {};

        // loading variable to show the spinning loading icon
        $scope.loading = true;

        loadData();

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
    })

     .controller('recipesController',function($scope, $controller , $http ){

        $controller('homeController', {$scope: $scope});

        
    })


    .controller('documentsController',function($scope, $controller ,$http ){

        $controller('homeController', {$scope: $scope});
        
    })


    .controller('shoppingController',function($scope, $controller ,$http, Authenticate, Todos, Flash){

        $controller('homeController', {$scope: $scope});
        
    })

    .controller('tagsController',function($scope, $controller, $route, $templateCache, $http,  Users, Tags, Flash){

        $controller('homeController', {$scope: $scope});
       
        $scope.data = {};

         // object to hold all tags of LoggedInUser
        $scope.data.tags = {};
        $scope.data.name = "";
        $scope.data.color = "";

        loadData();

        function loadData(){
            //Fetch all tags for LoggedInUser
            Users.getTags(sessionStorage.loggedUserId)
                .success(function(data){
                    $scope.data.tags = data.data;
            });
        }

        $scope.save = function(){
            
            Tags.save({
                'owner_id' : sessionStorage.loggedUserId,
                'name' : $scope.data.name,
                'color' : $scope.data.color,
                "tagable_id" : sessionStorage.loggedUserId,  
                "tagable_type" : "User"
           })
            .success(function(response){
                var currentPageTemplate = $route.current.templateUrl;
                $templateCache.remove(currentPageTemplate);
                $route.reload();
            });
        }
       
    })
;

    