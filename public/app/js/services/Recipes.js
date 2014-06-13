angular.module('myApp')
    
    .factory('Recipes', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/recipe');
            },
            getRecipesPerPage : function(pagenum) {
                return $http.get('/api/v1/recipes/page/' + pagenum);
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
            save : function(recipeData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(recipeData)
                });
            },
            addtag : function(tagid, recipeid) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe/'+ recipeid +'/addtag',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(tagid)
                });
            },
            removetag : function(tagid, recipeid) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/recipe/'+ recipeid +'/removetag',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(tagid)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/recipe/' + id);
            }
        }
    });