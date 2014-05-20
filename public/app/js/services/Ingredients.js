angular.module('myApp')

    .factory('Ingredients', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/ingredient');
            },
            show : function(id) {
                return $http.get('/api/v1/ingredient/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/ingredient',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/ingredient/' + id);
            }
        }
    });