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
  .directive('fnManagetodo', function() {
    return {
          scope: true, 
          restrict: 'C',
          replace: true,
          templateUrl: 'app/partials/directives/managetodo.html',
      };
  })
  // this tags class is added to messages.html and todos.html
  .directive('tags', function() {
    return {
          scope: true,
          restrict: 'C',
          replace: true,
          link: function (scope, element) {
            element.ready(function () {
                element.select2({
                  tags: 0,
                  width: '100%'
                });
            })
        }
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
	})

  // this class is added in add_recipes.html
  .directive('select2', function() {
    return {
          scope: true,
          restrict: 'C',
          replace: true,
          link: function (scope, element) {
            element.ready(function () {
                element.select2({
                  width: '100%'
                });
            })
        }
      };
  })
  .directive('fnManageuserprofile', function() {
    return {
          scope: true,
          restrict: 'C',
          replace: true,
          templateUrl: 'app/partials/directives/manageuserprofile.html',
      };
  });