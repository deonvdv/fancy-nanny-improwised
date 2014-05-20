angular.module('myApp')

    .factory('Tags', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/tag');
            },
            show : function(id) {
                return $http.get('/api/v1/tag/' + id);
            },
            save : function(tagData){
                if('id' in tagData) {
                     return $http({
                        method: 'PUT',
                        url: '/api/v1/tag/'+ tagData.id,
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(tagData)
                    });
                } else {
                    return $http({
                        method: 'POST',
                        url: '/api/v1/tag',
                        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                        data: $.param(tagData)
                    });
                }
            },
            destroy : function(id) {
                return $http.delete('/api/v1/tag/' + id);
            }
        }
    });