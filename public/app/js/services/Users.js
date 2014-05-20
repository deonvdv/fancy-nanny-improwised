angular.module('myApp')
    
    .factory('Users', function($http) {
        return {
            getUpcomingEvents : function(id) {
                return $http.get('/api/v1/user/' + id + '/upcoming_events');
            },
            getTags : function(id) {
                return $http.get('/api/v1/user/' + id + '/tags');
            },
            getPictures : function(id) {
                return $http.get('/api/v1/user/' + id + '/pictures');
            },
            getRecipes : function(id) {
                return $http.get('/api/v1/user/' + id + '/recipes');
            },
            getFavoriteRecipes : function(id) {
                return $http.get('/api/v1/user/' + id + '/favorite_recipes');
            },
            show : function(id) {
                return $http.get('/api/v1/user/' + id);
            },
            save : function(userData) {
                if('id' in userData){
                    return $http({
                        method: 'PUT',
                        url: '/api/v1/user/'+ userData.id,
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(userData)
                    });
                } else {
                    return $http({
                        method: 'POST',
                        url: '/api/v1/user',
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(userData)
                    });
                }
            },
            destroy : function(id) {
                return $http.delete('/api/v1/user/' + id);
            }
        }
    });