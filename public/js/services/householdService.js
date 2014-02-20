angular.module('householdService', [])

	.factory('Household', function($http) {

		return {
			get : function() {
				return $http.get('/api/v1/households');
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