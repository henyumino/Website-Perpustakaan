var usersborrowBookDetail = angular.module('usersborrowBookDetailApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 usersborrowBookDetail.controller('usersborrowBookDetailController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.borrowBookstep2 = function() 
    {
      $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/users_borrow_book_step2.php",
               data: {
                       code         : $window._aFgQ1,
                       bookid       : $window._aFgQ2,
                       numberofbook : $window._aFgQ3,
                       usersid      : $window._aFgQ4,
                       day          : $scope.day
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
            $scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
                if (res['Type'] == 'success') 
                {
                    window.location = "http://localhost:8080/projekuas/my_book/todo.php?id=" + $window._aFgQ2 + "&code=" + $window._aFgQ1;
                }
                else 
                {
                   swal(res['Title'], res['Message'], res['Type']);
                }
            }
            else 
            {
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.', 'error');
            }
    })}
});