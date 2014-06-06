angular.module('myApp')

    .factory('Ingredients', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/ingredient');
            },
            getIngredientsPerPage : function(pagenum) {
                return $http.get('/api/v1/ingredients/page/' + pagenum);
            },
            show : function(id) {
                return $http.get('/api/v1/ingredient/' + id);
            },
            save : function(ingredient) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/ingredient',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(ingredient)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/ingredient/' + id);
            }
        }
    });