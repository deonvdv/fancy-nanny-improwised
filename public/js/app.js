var app = angular.module('fancyNannyApp', ['mainCtrl', 'householdService', ]);
// var app = angular.module('fancyNannyApp',['mainCtrl', 'householdService','ngRoute']);

// app.config(function($routeProvider) {
//   $routeProvider.when('/login', {
//     templateUrl: 'js/login.html',
//     controller: 'LoginCtrl'
//   });
//   $routeProvider.when('/', {
//     templateUrl: 'js/home.html',
//     controller: 'HomeCtrl'
//   });
//   $routeProvider.otherwise({ redirectTo: '/' });
// });
// app.run(function(authentication, $rootScope, $location) {
//   $rootScope.$on('$routeChangeStart', function(evt) {
//     if(!authentication.isAuthenticated){ 
//       $location.url("/login");
//     }
//     event.preventDefault();
//   });
// })

// app.controller('LoginCtrl', function($scope, $http, $location, authentication) {
//   $scope.login = function() {
//     if ($scope.username === 'admin' && $scope.password === 'pass') {
//       console.log('successful')
//       authentication.isAuthenticated = true;
//       authentication.user = { name: $scope.username };
//       $location.url("/");
//     } else {
//       $scope.loginError = "Invalid username/password combination";
//       console.log('Login failed..');
//     };
//   };
// });

// app.controller('AppCtrl', function($scope, authentication) {
//   $scope.templates =
//   [
//   	{ url: 'login.html' },
//   	{ url: 'home.html' }
//   ];
//     $scope.template = $scope.templates[0];
//   $scope.login = function (username, password) {
//     if ( username === 'admin' && password === '1234') {
//   		authentication.isAuthenticated = true;
//   		$scope.template = $scope.templates[1];
//   		$scope.user = username;
//     } else {
//   		$scope.loginError = "Invalid username/password combination";
//     };
//   };
  
// });

// app.controller('HomeCtrl', function($scope, authentication) {
//   $scope.user = authentication.user.name;
  
// });

// app.factory('authentication', function() {
//   return {
//     isAuthenticated: false,
//     user: null
//   }
// });