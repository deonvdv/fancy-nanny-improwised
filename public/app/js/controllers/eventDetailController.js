angular.module('myApp')

    // event Detail controller ------------------------------------------------------------------------------
    .controller('eventDetailController',function($scope, $controller, $http, Events, $routeParams, Users, $timeout){

        $controller('homeController', {$scope: $scope});

        // ==============================================================================

        // event detail for perticuler event ( for page --> eventdetail.html )

        $scope.eventDetail = {};

        $scope.eventDetail = function() {

            // load event using route params(event id)
            Events.show($routeParams.eventId)
                .success(function(response){
                    $scope.eventDetail = response.data;
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

        $scope.dropCallback = function (event, ui, eventDetail, tag) {

            var last_tag = eventDetail.tags.length;

            if(last_tag === 1){

                var tag = {};
                tag.tag_id = eventDetail.tags[last_tag-1].id;
                Events.addtag(tag,eventDetail.id)
                    .success(function(response){
                        $scope.sucessTagAdd = true;
                        $scope.doneTagAdd();
                });

            }

            else{

                for(i=0;i<last_tag-1;i++){
                    if ( eventDetail.tags[i].id === eventDetail.tags[last_tag-1].id ){
                        console.log("tag is already in list");
                        eventDetail.tags.pop(eventDetail.tags[last_tag-1]);
                        console.log(eventDetail.tags);
                        $scope.sucessTagExist = true;
                        $scope.doneTagExist();
                        break;
                    }
                }

                if(eventDetail.tags[last_tag-1] === undefined){
                    console.log("not add");
                }
                else{

                    var tag = {};
                    tag.tag_id = eventDetail.tags[last_tag-1].id;
                    Events.addtag(tag,eventDetail.id)
                        .success(function(response){
                            $scope.sucessTagAdd = true;
                            $scope.doneTagAdd();
                    });
                }

            }

        };

        // ==============================================================================

         $scope.drop_tag = function(item,eventDetail,$index){
            var tag = {};
            tag.tag_id = item.id;
            Events.removetag(tag,eventDetail.id)
                .success(function(response){
                    eventDetail.tags.splice($index,1);
                    $scope.sucessTagRemove = true;
                    $scope.doneTagRemove();
            });
        };

        // ==============================================================================

    });