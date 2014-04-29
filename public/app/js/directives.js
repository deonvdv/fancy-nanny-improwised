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
	.directive('fnDashboard', function() {
		return {
    		  scope: true, 
      		restrict: 'C',
      		replace: true,
      		templateUrl: 'app/partials/directives/dashboard.html',
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
  .directive('fnManagemessages', function() {
    return {
          scope: true, 
          restrict: 'C',
          replace: true,
          templateUrl: 'app/partials/directives/managemessages.html',
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

  .directive('fnAddrecipes', function() {
    return {
          scope: true,
          restrict: 'C',
          replace: true,
          templateUrl: 'app/partials/directives/manage_add_recipes.html',
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

  .directive('fnManagedocuments', function() {
    return {
          scope: true,
          restrict: 'C',
          replace: true,
          templateUrl: 'app/partials/directives/managedocuments.html',
      };
  })

  .directive('fnManageshopping', function() {
    return {
          scope: true,
          restrict: 'C',
          replace: true,
          templateUrl: 'app/partials/directives/manageshopping.html',
      };
  })
  .directive('fnManagetags', function() {
    return {
          transclude: true,
          require:"ngModel",
          restrict: 'CE',
          replace: true,
          templateUrl: 'app/partials/directives/managetags.html',          
      };
  })
  .directive('fnManagerecipes', function() {
    return {
          scope: true,
          restrict: 'C',
          replace: true,
          templateUrl: 'app/partials/directives/managerecipes.html',
      };
  })
  .directive('fnManagerecipedetail', function() {
    return {
          scope: true,
          restrict: 'C',
          replace: true,
          templateUrl: 'app/partials/directives/managerecipedetail.html',
      };
  });