angular.module('myApp')
    
    .factory('Households', function($http) {
        return {
            getAll : function() {
                return $http.get('/api/v1/household');
            },
            get : function(id) {
                return $http.get('/api/v1/household/' + id);
            },
            getDocuments : function(id) {
                return $http.get('/api/v1/household/' + id + '/documents');
            },
            getMessages : function(id) {
                return $http.get('/api/v1/household/' + id + '/messages');
            },
            getTags : function(id) {
                return $http.get('/api/v1/household/' + id + '/tags');
            },
            getMembers : function(id) {
                return $http.get('/api/v1/household/' + id + '/members');
            },
            getMeals : function(id) {
                return $http.get('/api/v1/household/' + id + '/meals');
            },
            getRecipes : function(id) {
                return $http.get('/api/v1/household/' + id + '/recipes');
            },
            getTodayMeals : function(id) {
                return $http.get('/api/v1/household/' + id + '/todaymeals');
            },
            getEvents : function(id) {
                return $http.get('/api/v1/household/' + id + '/events');
            },
            getTodos : function(id) {
                return $http.get('/api/v1/household/' + id + '/todos');
            },
            getNotifications : function(id) {
                return $http.get('/api/v1/household/' + id + '/notifications');
            },
            show : function(id) {
                return $http.get('/api/v1/household/' + id);
            },
            save : function(householdData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/household',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(householdData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/household/' + id);
            }
        }
    });