angular.module('myApp')
    
    .factory('Events', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/event');
            },
            getAttendees : function(id) {
                return $http.get('/api/v1/event/' + id + '/attendees');
            },
            getTags : function(id) {
                return $http.get('/api/v1/event/' + id + '/tags');
            },
            show : function(id) {
                return $http.get('/api/v1/event/' + id);
            },
            save : function(eventData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/event',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(eventData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/event/' + id);
            }
        }
    });