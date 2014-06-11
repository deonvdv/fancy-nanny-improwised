angular.module('myApp')

    // recipes controller ------------------------------------------------------------------------------
    .controller('recipeDetailController',function($scope, $http, $controller, $routeParams, Recipes, Users,$timeout){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // recipe detail for perticuler recipe ( for page --> recipedetail.html )

        $scope.recipeDetail = {};

        $scope.recipeDetail = function() {

            // load recpie using route params(recipe id)
            Recipes.show($routeParams.recipeId)
                .success(function(response){
                    $scope.recipeDetail = response.data;
            });

        };

        // ==============================================================================

        $scope.tags = {};

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

        $scope.dropCallback = function (event, ui, recipeDetail, tag) {

            var last_tag = recipeDetail.tags.length;

            if(last_tag === 1){

                console.log(recipeDetail.tags[last_tag-1]);

            }

            else{

                for(i=0;i<last_tag-1;i++){
                    if ( recipeDetail.tags[i].id === recipeDetail.tags[last_tag-1].id ){
                        console.log("tag is already in list");
                        recipeDetail.tags.pop(recipeDetail.tags[last_tag-1]);
                        console.log(recipeDetail.tags);
                        $scope.sucess = true;
                        $scope.done();
                        break;
                    }
                }

                if(recipeDetail.tags[last_tag-1] === undefined){
                    console.log("not add");
                }
                else{
                    console.log("add");
                }

            }

        };

        // ==============================================================================

    });