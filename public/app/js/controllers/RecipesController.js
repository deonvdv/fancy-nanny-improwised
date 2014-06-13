angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('recipesController',function($scope, $controller, $http, $routeParams, Recipes, Categories, $route, Users, Tags, $timeout){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // object to hold all the data for the favorite recipes

        $scope.favoriterecipe = [];

        loadfavoriterecipe();

        function loadfavoriterecipe(){
            //Fetch all Fevorite Recipes for LoggedIn User.
            Users.getFavoriteRecipes(sessionStorage.loggedUserId)
                .success(function(data) {
                    $scope.favoriterecipe = data.data;
                    console.log($scope.favoriterecipe);
            });
        }

        // ==============================================================================

        // load all ingredients

        $scope.Categories = {};

        loadCategory();

        function loadCategory(){
            //load all categories.
            Categories.get()
                .success(function(data) {
                    $scope.Categories = data.data;
            });
        }

        // ==============================================================================

        // object to hold all the data for the recipes

        $scope.recipes = {};

        $scope.recipes.tags = {};

        list2 = [];

        $scope.recipes.fav = "favoriterecipedone";

        loadrecipes();

        function loadrecipes(){

            //Fetch all Recipes for LoggedIn user's household.

            Recipes.get()
                .success(function(data) {

                    $scope.TotalRecipes =data.total_item;

                    $scope.TotalPages = data.total_page;

                    $scope.RecipesPerPage = data.items_per_page;

                    $scope.recipes = data.data;

            });

        }

        // ==============================================================================

        // this method called when page changes.

        $scope.getRecipespages = function(){

            if($scope.CurrentRecipesPage !== ''){

                Recipes.getRecipesPerPage($scope.CurrentRecipesPage)
                    .success(function(data) {

                        $scope.recipes = data.data;

                });

            }

        }


        // ==============================================================================

        // make recipe favorite ( for page --> recipes.html )

        $scope.favRecipe = {};

        $scope.favRecipe.recipe_id = "";

        $scope.favRecipe.user_id = sessionStorage.loggedUserId;

        $scope.makeFavorite = function (recipe) {

            $scope.favRecipe.recipe_id = recipe.id;

            if(recipe.fav !== "favoriterecipedone"){

                recipe.fav = "favoriterecipedone";

                // Users.save($scope.favRecipe)
                //     .success(function(response){
                //         $scope.favRecipe = response.data;
                // });
            }

        };

        $scope.initFav = function(recipe){

            for( i=0 ; i < $scope.favoriterecipe.length ; i++){

                if ($scope.favoriterecipe[i].id === recipe.id){

                    recipe.fav = "favoriterecipedone";
                    break;

                }

            }

        };

        // ==============================================================================

        // object to hold all tags of LoggedInUser

        $scope.tags = {};
        $scope.tags.name = "";
        $scope.tags.color = "";
        $scope.tags.fontcolor = "";
        $scope.tags.drag = true;

        loadData();

        function loadData(){
            //Fetch all tags for LoggedInUser
            Users.getTags(sessionStorage.loggedUserId)
                .success(function(data){
                    $scope.tags = data.data;
            });
        }

        // ==============================================================================

        $scope.sucess = false;

        $scope.done = function(){
            $timeout(function () { $scope.sucess = false; }, 3000);
        };

        // ==============================================================================

        $scope.dropCallback = function (event, ui, recipe, tag) {

            var last_tag = recipe.tags.length;

            // add first tag in recipe
            if(last_tag === 1){
                var tag = {};
                tag.tag_id = recipe.tags[last_tag-1].id;
                Recipes.addtag(tag,recipe.id);

            }

            else{

                for(i=0;i<last_tag-1;i++){
                    if ( recipe.tags[i].id === recipe.tags[last_tag-1].id ){
                        console.log("tag is already in list");
                        recipe.tags.pop(recipe.tags[last_tag-1]);
                        console.log(recipe.tags);
                        $scope.sucess = true;
                        $scope.done();
                        break;
                    }
                }

                if(recipe.tags[last_tag-1] === undefined){}

                // add tags in recipe
                else{
                    var tag = {};
                    tag.tag_id = recipe.tags[last_tag-1].id;
                    Recipes.addtag(tag,recipe.id);

                }

            }

        };

        // ==============================================================================

        $scope.drop_tag = function(item){
            $scope.recipe.tags.pop(item);
        };

    });