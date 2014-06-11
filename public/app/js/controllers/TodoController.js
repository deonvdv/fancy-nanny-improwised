angular.module('myApp')

    // todo controller ------------------------------------------------------------------------------
    .controller('todoController',function($scope, $controller ,$location, $http, $route, Authenticate, Todos, Flash, Households, Users, $timeout){
       
        $controller('homeController', {$scope: $scope})

        // ==============================================================================

        // object to hold all the data for the assignedTo todos
        $scope.assignedToTodos = {};

        // object to hold all the data for the completed todos by LoggedInUser
        $scope.completedTodos = {};
        
        // loading variable to show the spinning loading icon
        $scope.loading = true;

        loadData();

        $scope.refresh = loadData();

        // ==============================================================================

        // hold household members
        $scope.members = {};

        // object holds all the propertics of add new todo from DOM
        $scope.SentTodo = {};

        // object holds assigned to id
        $scope.SentTodo.owner_id = sessionStorage.loggedUserId;

        // object that store logged in user id user id
        $scope.SentTodo.assigned_by = sessionStorage.loggedUserId;

        // object holds assigned to id
        $scope.SentTodo.assigned_to = [];

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

        // ==============================================================================

        // get household members
        Households.getMembers(sessionStorage.householdId)
            .success(function(data) {
                $scope.members = data.data;
        });

        // ==============================================================================

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

        // ==============================================================================

        // this method fires when new todo is added from DOM.
        $scope.SentTodos = function(form){

            $scope.SentTodo.minutes_before = 5;
            $scope.SentTodo.is_complete = 0;
            //this method save new todo into the database

            $scope.submitted = true;

            if(form.$valid) {

                Todos.save($scope.SentTodo)
                    .success(function(response){
                        $scope.SentTodo = response.data;
                        $route.reload();
                });

            }

        }

        // ==============================================================================

        // make todo complete

        $scope.makeTodoFav = function (todo) {

                todo.done = "icon-position-c";

                todo.is_complete = 1;

                // method that save the status of todo in database (  incomplete to complete  )

                // here

        };

        // ==============================================================================

        $scope.tags = {};

        loadData12();

        function loadData12(){
            //Fetch all tags for LoggedInUser
            Users.getTags(sessionStorage.loggedUserId)
                .success(function(data){
                    $scope.tags = data.data;
            });
        }

        // ==============================================================================

        $scope.sucess = false;

        $scope.done = function(){
            $timeout(function () { $scope.sucess = false; }, 5000);
        };

        // ==============================================================================

        $scope.dropCallback = function (event, ui, todo, tag) {

            var last_tag = todo.tags.length;

            if(last_tag === 1){

                console.log(todo.tags[last_tag-1]);

            }

            else{

                for(i=0;i<last_tag-1;i++){
                    if ( todo.tags[i].id === todo.tags[last_tag-1].id ){
                        console.log("tag is already in list");
                        todo.tags.pop(todo.tags[last_tag-1]);
                        console.log(todo.tags);
                        $scope.sucess = true;
                        $scope.done();
                        break;
                    }
                }

                if(todo.tags[last_tag-1] === undefined){
                    console.log("not add");
                }
                else{
                    console.log("add");
                }

            }

        };

        // ==============================================================================

    });