angular.module('myApp')
    
    .factory('RecipeReviews', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/recipe_review');
            },
            show : function(id) {
                return $http.get('/api/v1/recipe_review/' + id);
            },
            save : function(recipeReviewData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe_review',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(recipeReviewData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/recipe_review/' + id);
            }
        }
    });