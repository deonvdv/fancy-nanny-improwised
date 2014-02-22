angular.module('myApp')
    .factory('Authenticate', function($resource){
        return $resource("/api/v1/authenticate/")
    })
    .factory('Households', function($resource){
        return $resource("/api/v1/household")
    })
    .factory('Flash', function($rootScope){
        return {
            show: function(message){
                $rootScope.flash = message
            },
            clear: function(){
                $rootScope.flash = ""
            }
        }
    })