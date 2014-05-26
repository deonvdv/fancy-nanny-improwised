angular.module("myApp")
    .config(['$routeProvider',function($routeProvider){

        $routeProvider.when('/',{templateUrl:'app/partials/login.html', controller: 'loginController'})

        $routeProvider.when('/home',{templateUrl:'app/partials/home.html', controller: 'homeController'})

        $routeProvider.when('/todos',{templateUrl:'app/partials/todos.html', controller: 'todoController'})

        $routeProvider.when('/messages',{templateUrl:'app/partials/messages.html', controller: 'messageController'})

        $routeProvider.when('/add_recipes',{templateUrl:'app/partials/add_recipes.html', controller: 'recipesController'})

        $routeProvider.when('/documents',{templateUrl:'app/partials/documents.html', controller: 'documentsController'})

        $routeProvider.when('/shopping',{templateUrl:'app/partials/shopping.html', controller: 'shoppingController'})

        $routeProvider.when('/tags',{templateUrl:'app/partials/tags.html', controller: 'tagsController'})

        $routeProvider.when('/recipes',{templateUrl:'app/partials/recipes.html', controller: 'recipesController'})

        $routeProvider.when('/recipe_detail/:recipeId',{templateUrl:'app/partials/recipedetail.html', controller: 'recipesController'})

        $routeProvider.when('/user_profile',{templateUrl:'app/partials/userprofile.html', controller: 'userController'})

        $routeProvider.when('/edit_profile',{templateUrl:'app/partials/editprofile.html', controller: 'editUserController'})

        $routeProvider.when('/calender',{templateUrl:'app/partials/calender.html', controller: 'calenderController'})

        $routeProvider.when('/events',{templateUrl:'app/partials/events.html', controller: 'eventsController'})

        $routeProvider.otherwise({redirectTo :'/'})
    }]);