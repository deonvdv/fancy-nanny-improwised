angular.module('myApp')
    
    .factory('Meals', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/meal');
            },
            show : function(id) {
                return $http.get('/api/v1/meal/' + id);
            },
            save : function(mealData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/meal',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(mealData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/meal/' + id);
            }
        }
    });