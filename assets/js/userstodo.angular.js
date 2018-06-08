var usersTodo = angular.module('usersTodoApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 usersTodo.controller('usersTodoController', function($scope, $http, $timeout, cfpLoadingBar) {

 	$http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

    $scope.start = function() {
      cfpLoadingBar.start();
    }

    $scope.complete = function() {
      cfpLoadingBar.complete();
    }

    $scope.start();

    $timeout(function () {
      $scope.complete();
    }, 2000);

    $scope.GotoDashboardPage = function() {
      window.location = "http://localhost:8080/projekuas/dashboard/"; 
    }

    $scope.GotoLogout = function() {
      window.location = "http://localhost:8080/projekuas/logout/";  
    }
});