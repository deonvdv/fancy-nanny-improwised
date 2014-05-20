angular.module('myApp')

    .factory('UnitOfMeasures', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/unit_of_measure');
            },
            show : function(id) {
                return $http.get('/api/v1/unit_of_measure/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/unit_of_measure',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/unit_of_measure/' + id);
            }
        }
    });