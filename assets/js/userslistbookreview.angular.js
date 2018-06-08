var usersListBookReview = angular.module('usersListBookReviewApp', ['chieffancypants.loadingBar', 'jkAngularRatingStars', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 usersListBookReview.controller('usersListBookReviewController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.first     = 1;
    $scope.second    = 2;
    $scope.third     = 3;
    $scope.fourth    = 4;
    $scope.five      = 5;
    $scope.readOnly  = true;

    $scope.GotoAccountSettings = function() {
        window.location = 'http://localhost:8080/projekuas/settings/'; 
    }

    $scope.GotoLogout = function() {
        window.location = 'http://localhost:8080/projekuas/logout/';      
    }

    $scope.GotoBookPage = function() {
        window.location = 'http://localhost:8080/projekuas/dashboard/';
    }

    $scope.GotoMyBookPage = function() {
        window.location = 'http://localhost:8080/projekuas/my_book/';
    }
});