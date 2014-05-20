angular.module('myApp')
    
    .factory('Todos', function($http) {
        return {
            get : function(id) {
                return $http.get('/api/v1/todo/' + id + '/assigned');
            },
            getAssignedTo : function(id) {
                return $http.get('/api/v1/todo/' + id + '/assignedto');
            },
            getCompleted : function(id) {
                return $http.get('/api/v1/todo/' + id + '/completed');
            },                     
            getTags : function(id) {
                return $http.get('/api/v1/todo/' + id + '/tags');
            },
            show : function(id) {
                return $http.get('/api/v1/todo/' + id);
            },
            save : function(todoData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/todo',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(todoData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/todo/' + id);
            }
        }
    });