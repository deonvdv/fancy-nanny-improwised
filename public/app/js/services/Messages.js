angular.module('myApp')
    
    .factory('Messages', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/message');
            },
            getUnread : function(id) {
                return $http.get('/api/v1/message/' + id + '/unread')
            },
            getReceived : function(id) {
                return $http.get('/api/v1/message/' + id + '/received')
            },
            getSent : function(id) {
                return $http.get('/api/v1/message/' + id + '/sent')
            },            
            show : function(id) {
                return $http.get('/api/v1/message/' + id);
            },
            save : function(messageData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/message',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(messageData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/message/' + id);
            }
        }
    });