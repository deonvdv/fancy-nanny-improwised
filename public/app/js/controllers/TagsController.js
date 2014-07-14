angular.module('myApp')

     // tags controller ------------------------------------------------------------------------------
    .controller('tagsController',function($scope, $modal, $controller, $route, $templateCache, $http,  Users, Tags, Flash){

        $controller('homeController', {$scope: $scope});
       
        $scope.data = {};


        // object to hold all tags of LoggedInUser
        $scope.data.tags = {};
        $scope.data.name = "";
        $scope.data.color = "";
        $scope.data.fontcolor = "";

        loadData();

        function loadData(){
            //Fetch all tags for LoggedInUser
            Users.getTags(sessionStorage.loggedUserId)
                .success(function(data){
                    $scope.data.tags = data.data;
            });
        }

        // edit tag method of modal
        $scope.editTag = function(tag) {
            var modalInstance = $modal.open({
                templateUrl: 'editTagmodal.html',
                controller: editTagCtrl,
                resolve: {
                    tag: function() {
                        return tag;
                    }
                }
            });

        }

        // edit tag controller
        var editTagCtrl = function ($scope, $modalInstance, tag) {


            $scope.title = "Edit";

            if(tag === undefined) {
                tag = {};
                $scope.title = "Add";
            } else {
                Tags.show(tag.id)
                    .success(function(response){
                        tag = response.data;
                    });
            }

            $scope.options = [
                { label: 'White', value: 'white' },
                { label: 'Black', value: 'black' }
            ];


            $scope.data = tag;
            $scope.data.owner_id = sessionStorage.loggedUserId;

            $scope.save = function (form) {

                // bind fontcolorOption to fontcolor
                // $scope.data.fontcolor = $scope.data.fontcolorOption.value;

                $scope.submitted = true;
                if(form.$valid) {
                    Tags.save($scope.data)
                        .success(function(response){
                            $modalInstance.close($scope.data.tag);
                            $route.reload();
                    });
                }
            };

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };

        };

        // delete tag method of modal
        $scope.deleteTag = function(tag) {

            var modalInstance = $modal.open({
                templateUrl: 'delete.html',
                controller: deleteTagCtrl,
                resolve: {
                    tag: function(){
                        return tag;
                    }
                }
            });

        }

        // delete tag controller
        var deleteTagCtrl = function ($scope, $modalInstance, tag) {

            $scope.data = tag;

            $scope.delete = function () {
                Tags.destroy($scope.data.id)
                    .success(function(response){
                        $modalInstance.close($scope.data);
                        $route.reload();
                    });
            }

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };
        };

    });