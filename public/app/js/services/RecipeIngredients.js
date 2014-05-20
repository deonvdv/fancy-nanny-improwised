angular.module('myApp')

    .factory('RecipeIngredients', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/recipe_ingredient');
            },
            show : function(id) {
                return $http.get('/api/v1/recipe_ingredient/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe_ingredient',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/recipe_ingredient/' + id);
            }
        }
    });