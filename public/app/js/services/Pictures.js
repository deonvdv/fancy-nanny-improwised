angular.module('myApp')
    
    .factory('Pictures', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/picture');
            },            
            show : function(id) {
                return $http.get('/api/v1/picture/' + id);
            },
            save : function(pictureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/picture',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(pictureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/picture/' + id);
            }
        }
    });