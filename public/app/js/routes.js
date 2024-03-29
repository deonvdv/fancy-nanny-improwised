angular.module("myApp")
    .config(['$routeProvider',function($routeProvider){

        $routeProvider.when('/',{templateUrl:'app/partials/login.html', controller: 'loginController'})

        $routeProvider.when('/home',{templateUrl:'app/partials/home.html', controller: 'homeController'})

        $routeProvider.when('/todos',{templateUrl:'app/partials/todos.html', controller: 'todoController'})

        $routeProvider.when('/messages',{templateUrl:'app/partials/messages.html', controller: 'messageController'})

        $routeProvider.when('/add_recipes',{templateUrl:'app/partials/add_recipes.html', controller: 'addNewRecipeController'})

        $routeProvider.when('/documents',{templateUrl:'app/partials/documents.html', controller: 'documentsController'})

        $routeProvider.when('/shopping',{templateUrl:'app/partials/shopping.html', controller: 'shoppingController'})

        $routeProvider.when('/tags',{templateUrl:'app/partials/tags.html', controller: 'tagsController'})

        $routeProvider.when('/recipes',{templateUrl:'app/partials/recipes.html', controller: 'recipesController'})

        $routeProvider.when('/recipe_detail/:recipeId',{templateUrl:'app/partials/recipedetail.html', controller: 'recipeDetailController'})

        $routeProvider.when('/user_profile',{templateUrl:'app/partials/userprofile.html', controller: 'userController'})

        $routeProvider.when('/edit_profile',{templateUrl:'app/partials/editprofile.html', controller: 'editUserController'})

        $routeProvider.when('/calender',{templateUrl:'app/partials/calender.html', controller: 'calenderController'})

        $routeProvider.when('/events',{templateUrl:'app/partials/events.html', controller: 'eventsController'})

        $routeProvider.when('/events/:eventId',{templateUrl:'app/partials/eventdetail.html', controller: 'eventDetailController'})

        $routeProvider.when('/ingredients',{templateUrl:'app/partials/ingredients.html', controller: 'IngredientsController'})

        $routeProvider.when('/categories',{templateUrl:'app/partials/categories.html', controller: 'CategoriesController'})

        $routeProvider.when('/Unit_Of_Measure',{templateUrl:'app/partials/unit_of_measure.html', controller: 'UnitOfMeasureController'})

        $routeProvider.when('/add_Meal',{templateUrl:'app/partials/add_Meal.html', controller: 'addNewMealController'})

        $routeProvider.otherwise({redirectTo :'/'})
    }]);