angular.module('myApp')
    
    .factory('Documents', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/document');
            },            
            show : function(id) {
                return $http.get('/api/v1/document/' + id);
            },
            save : function(documentData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/document',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(documentData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/document/' + id);
            }
        }
    });