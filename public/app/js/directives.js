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
          link: function (scope, elm, attrs) {
              $(".cl-toggle").click(function(e){
                var ul = $(".cl-vnavigation");
                ul.slideToggle(300, 'swing', function () {
                });
                e.preventDefault();
              });
          }
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
	})

  .directive('validPasswordC', function () {
      return {
          require: 'ngModel',
          link: function (scope, elm, attrs, editController) {
              editController.$parsers.unshift(function (viewValue, $scope) {
                  var noMatch = viewValue != scope.form.password.$viewValue
                  editController.$setValidity('noMatch', !noMatch)
              })
          }
      }
  })

  .directive('hax', function() {
    var HAX_REGEXP = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/;
    return {
      require: 'ngModel',
      link: function(scope, elm, attrs, tagsController) {
        tagsController.$parsers.unshift(function(viewValue) {
          if (HAX_REGEXP.test(viewValue)) {
            // it is valid
            tagsController.$setValidity('hax', true);
            return viewValue;
          } else {
            // it is invalid, return undefined (no model update)
            tagsController.$setValidity('hax', false);
            return undefined;
          }
        });
      }
    };
  });