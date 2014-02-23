angular.module('mainCtrl', [])

	.controller('mainController', function($scope, $http, Household) {

		
		// object to hold all the data for the new comment form
		$scope.householdData = {};

		// loading variable to show the spinning loading icon
		$scope.loading = true;
		
		// get all the household first and bind it to the $scope.households object
		Household.get()
			.success(function(data) {
				console.log(data);
				$scope.households = data.data;
				$scope.loading = false;
			});


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

		// function to handle deleting a household
		$scope.deleteHousehold = function(id) {
			$scope.loading = true; 

			Household.destroy(id)
				.success(function(data) {

					// if successful, we'll need to refresh the household list
					Household.get()
						.success(function(getData) {
							$scope.households = getData.data;
							$scope.loading = false;
						});

				});
		};
		

	});