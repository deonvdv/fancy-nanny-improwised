angular.module('myApp')
	.directive('fnhouseholdMembers', function() {
		return {
    		  scope: true, 
      		restrict: 'C',
      		replace: true,
      		templateUrl: 'app/partials/directives/householdMembers.html',
    	};
	})
	.directive('fnSidebar', function() {
		return {
    		  scope: true, 
      		restrict: 'C',
      		replace: true,
      		templateUrl: 'app/partials/directives/sidebar.html',
    	};
	})
	.directive('fntopNavbar', function() {
		return {
    		  scope: true, 
      		restrict: 'C',
      		replace: true,
      		templateUrl: 'app/partials/directives/topnavbar.html',
    	};
	})
	.directive('fncriticalInformation', function() {
		return {
    		  scope: true, 
      		restrict: 'C',
      		replace: true,
      		templateUrl: 'app/partials/directives/criticalinformation.html',
    	};
	})
	.directive('fnemergencyContact', function() {
		return {
    		  scope: true, 
      		restrict: 'C',
      		replace: true,
      		templateUrl: 'app/partials/directives/emergencycontact.html',
    	};
	});