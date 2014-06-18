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

        $scope.sucessTagExist = false;

        $scope.doneTagExist = function(){
            $timeout(function () { $scope.sucessTagExist = false; }, 4000);
        };

        // ==============================================================================

        $scope.sucessTagAdd = false;

        $scope.doneTagAdd = function(){
            $timeout(function () { $scope.sucessTagAdd = false; }, 4000);
        };

        // ==============================================================================

        $scope.sucessTagRemove = false;

        $scope.doneTagRemove = function(){
            $timeout(function () { $scope.sucessTagRemove = false; }, 4000);
        };

        // ==============================================================================

        $scope.dropCallback = function (event, ui, recipeDetail, tag) {

            var last_tag = recipeDetail.tags.length;

            if(last_tag === 1){

                var tag = {};
                tag.tag_id = recipeDetail.tags[last_tag-1].id;
                Recipes.addtag(tag,recipeDetail.id)
                    .success(function(response){
                        $scope.sucessTagAdd = true;
                        $scope.doneTagAdd();
                });

            }

            else{

                for(i=0;i<last_tag-1;i++){
                    if ( recipeDetail.tags[i].id === recipeDetail.tags[last_tag-1].id ){
                        console.log("tag is already in list");
                        recipeDetail.tags.pop(recipeDetail.tags[last_tag-1]);
                        console.log(recipeDetail.tags);
                        $scope.sucessTagExist = true;
                        $scope.doneTagExist();
                        break;
                    }
                }

                if(recipeDetail.tags[last_tag-1] === undefined){
                    console.log("not add");
                }
                else{

                    var tag = {};
                    tag.tag_id = recipeDetail.tags[last_tag-1].id;
                    Recipes.addtag(tag,recipeDetail.id)
                        .success(function(response){
                            $scope.sucessTagAdd = true;
                            $scope.doneTagAdd();
                    });
                }

            }

        };

        // ==============================================================================

         $scope.drop_tag = function(item,recipeDetail,$index){
            var tag = {};
            tag.tag_id = item.id;
            Recipes.removetag(tag,recipeDetail.id)
                .success(function(response){
                    recipeDetail.tags.splice($index,1);
                    $scope.sucessTagRemove = true;
                    $scope.doneTagRemove();
            });
        };

        // ==============================================================================

    });