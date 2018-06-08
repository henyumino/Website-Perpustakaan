var usersbookDetail = angular.module('usersbookDetailApp', ['chieffancypants.loadingBar', 'jkAngularRatingStars', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 usersbookDetail.controller('usersbookDetailController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.getRating = $window._yGx1a;
    $scope.readOnly  = true;

    $scope.GotoDashboardPage = function() {
      window.location = "http://localhost:8080/projekuas/dashboard/"; 
    }

    $scope.GotoLogout = function() {
      window.location = "http://localhost:8080/projekuas/logout/";  
    }

    $scope.errorborrowBook = function() {
      swal("Kesalahan", "Tidak dapat meminjam buku stok buku sudah habis!", "error");
    }

    $scope.borrowBook = function() 
    {
      $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/users_borrow_book.php",
               data: {
                       id           : $window._qpJ1,
                       booktitle    : $window._qpJ2,
                       usersid      : $window._qpJ3,
                       numberofbook : $window._qpJ4 
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
            $scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
                if (res['Type'] == 'success' || res['Type'] == 'type_2') 
                {
                    window.location = "http://localhost:8080/projekuas/dashboard/book.php?id=" + $window._qpJ1 + "&borrow_book_id=" + $window._qpJ1 + "&borrow_code=" + res['borrow_code'];
                }
                else if (res['Type'] == 'type_3')
                {
                  window.location = "http://localhost:8080/projekuas/my_book/todo.php?id=" + $window._qpJ1 + "&code=" + res['borrow_code'];
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