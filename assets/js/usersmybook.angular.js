var usersMyBook = angular.module('usersMyBookApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 usersMyBook.controller('usersMyBookController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

 	$http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

    $scope.start = function() {
      cfpLoadingBar.start();
    }

    $scope.complete = function() {
      cfpLoadingBar.complete();
    }

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

    $scope.GotoBookDetail = function(data) {
       window.location = 'http://localhost:8080/projekuas/dashboard/book.php?id=' + data.ID_Buku;
    }

    $scope.start();

    $timeout(function () {
      $scope.complete();
    }, 2000);

    $scope.errorsearchBorrowedBook = function() {
       swal("Kesalahan", "Judul buku masih kosong", "error");
    }

    $scope.searchBorrowedBook = function() {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/users_search_borrowed_book.php",
                        data: {
                                  usersid  : $window._yySc1,
                                  keyword  : $scope.keyword
                              },
                              headers: {'Content-Type': 'application/json'}
                }).then(function (response) {
                    $scope.complete();
                    var res = angular.fromJson(response.data);

                     if (typeof res === "object") 
                     {
                        if (res['Type'] == 'success') 
                        {
                             $scope.keyword         = "";
                             $scope.searchBorrowedBookForm.$setPristine();
                             $scope.searchBorrowedBookForm.$setUntouched();
                             $scope.showResult      = true;
                             $scope.showTableResult = true;
                             $scope.showTextResult  = false;
                             $scope.resultSearch    = res['result'];
                             $scope.getKeyword      = res['keyword'];
                        }
                        else if (res['Type'] == 'no_result')
                        {
                             $scope.showResult      = true;
                             $scope.showTableResult = false;
                             $scope.no_result       = $scope.keyword;
                             $scope.showTextResult  = true;
                        }
                        else
                        {
                             swal(res['Title'], res['Message'], res['Type']);
                        }
                      }
                      else 
                      {
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pencarian tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }
});