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
                    console.log($scope.eventDetail);
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

        $scope.dropCallback = function (event, ui, eventDetail, tag) {

            var last_tag = eventDetail.tags.length;

            if(last_tag === 1){

                console.log(eventDetail.tags[last_tag-1]);

            }

            else{

                for(i=0;i<last_tag-1;i++){
                    if ( eventDetail.tags[i].id === eventDetail.tags[last_tag-1].id ){
                        console.log("tag is already in list");
                        eventDetail.tags.pop(eventDetail.tags[last_tag-1]);
                        console.log(eventDetail.tags);
                        $scope.sucess = true;
                        $scope.done();
                        break;
                    }
                }

                if(eventDetail.tags[last_tag-1] === undefined){
                    console.log("not add");
                }
                else{
                    console.log("add");
                }

            }

        };

        // ==============================================================================

    });