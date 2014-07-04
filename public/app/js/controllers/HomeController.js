angular.module('myApp')

    // home controller ------------------------------------------------------------------------------
    .controller('homeController',function($scope, $location, $http, $anchorScroll, Authenticate, Users, Households, Messages, Todos, Flash, Recipes){
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
        $scope.userEvents = {};

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
                $scope.userEvents = data.data;
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



        // ==============================================================================


        $scope.favoriterecipe = [];

        loadfavoriterecipe();

        function loadfavoriterecipe(){
            //Fetch all Fevorite Recipes for LoggedIn User.
            Users.getFavoriteRecipes(sessionStorage.loggedUserId)
                .success(function(data) {
                    $scope.favoriterecipe = data.data;
            });
        }

        $scope.recipes = {};

        $scope.recipes.fav = "favoriterecipedone";

        loadrecipes();

        function loadrecipes(){
            //Fetch all Recipes for LoggedIn user's household.
            Recipes.get()
                .success(function(data) {
                    $scope.recipes = data.data;
            });
        }

        $scope.initFav = function(recipe){

            for( i=0 ; i < $scope.favoriterecipe.length ; i++){

                if ($scope.favoriterecipe[i].id === recipe.id){

                    recipe.fav = "favoriterecipedone";
                    break;

                }

            }

        };

        // ==============================================================================

        // make message read

        $scope.msgRead = function(msg){

            msg.is_read = 1;

            // method that save the status of todo in database (  incomplete to complete  )

                // here

        }

        // ==============================================================================


    });