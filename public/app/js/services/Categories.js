angular.module('myApp')

    .factory('Categories', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/category');
            },
            show : function(id) {
                return $http.get('/api/v1/category/' + id);
            },
            save : function(categoryData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/category',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(categoryData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/category/' + id);
            }
        }
    });