angular.module('myApp')
    
    .factory('Notifications', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/notification');
            },            
            show : function(id) {
                return $http.get('/api/v1/notification/' + id);
            },
            save : function(notificationData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/notification',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(notificationData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/notification/' + id);
            }
        }
    });