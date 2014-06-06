angular.module('myApp')

    .factory('UnitOfMeasures', function($http) {
        return {
            get : function() {
                return $http.get('/api/v1/units_of_measure');
            },
            getUnitsPerPage : function(pagenum) {
                return $http.get('/api/v1/units_of_measures/page/' + pagenum);
            },
            show : function(id) {
                return $http.get('/api/v1/units_of_measure/' + id);
            },
            save : function(unitOfMeasureData) {
                return $http({
                    method: 'POST',
                    url: '/api/v1/units_of_measure',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(unitOfMeasureData)
                });
            },
            destroy : function(id) {
                return $http.delete('/api/v1/units_of_measure/' + id);
            }
        }
    });