angular.module('myApp')
    
    .factory('Recipes', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/recipe');
            },
            getIngredients : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/recipe_ingredients');
            },
            getPictures : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/pictures');
            },
            getCategories : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/categories');
            },
            getTags : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/tags');
            },
            getReviews : function(id) {
                return $http.get('/api/v1/recipe/' + id + '/reviews');
            },
            show : function(id) {
                return $http.get('/api/v1/recipe/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/recipe/' + id);
            }
        }
    });