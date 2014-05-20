angular.module('myApp')
    .factory('Authenticate', function($resource){
        return $resource("/api/v1/authenticate/")
    });