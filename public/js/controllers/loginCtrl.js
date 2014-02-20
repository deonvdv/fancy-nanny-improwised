angular.module('loginCtrl', [])

	.controller('loginController', function($scope, $http, Household) {
		// object to hold all the data for the new comment form
		$scope.householdData = {};

		// loading variable to show the spinning loading icon
		$scope.loading = true;
		
		// function to handle submitting the form
		$scope.submitHousehold = function() {
			$scope.loading = true;

			// save the household. pass in household data from the form
			Household.save($scope.householdData)
				.success(function(data) {

					// if successful, we'll need to refresh the household list
					Household.get()
						.success(function(getData) {
							$scope.households = getData.data;
							$scope.loading = false;
						});

				})
				.error(function(data) {
					console.log(data);
				});
		};		

	});