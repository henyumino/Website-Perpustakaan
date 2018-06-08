var Home = angular.module('HomeApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 Home.controller('HomeController', function($window, $scope, $http, $timeout, cfpLoadingBar) {
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

    $scope.GotoRegisterPage = function() {
        window.location = 'http://localhost:8080/projekuas/register/';
    }

    $scope.GotoLoginPage = function() {
        window.location = 'http://localhost:8080/projekuas/login/';      
    }
});