var secretaryBookStatistic = angular.module('secretaryBookStatisticApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider, $compileProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|javascript):/);
  })

 secretaryBookStatistic.controller('secretaryBookStatisticController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.GotomanageBookPage = function() {
        window.location = 'http://localhost:8080/projekuas/secretary/dashboard/';
    }

    $scope.GotoAccountSettings = function() {
        window.location = 'http://localhost:8080/projekuas/secretary/settings/'; 
    }

    $scope.GotomanageCategoryPage = function() {
        window.location = 'http://localhost:8080/projekuas/secretary/manage_category/';  
    }

    $scope.GotoBookStatisticPage = function() {
        window.location = 'http://localhost:8080/projekuas/secretary/book_statistic/';      
    }

    $scope.GotoLogout = function() {
        window.location = 'http://localhost:8080/projekuas/secretary/logout/';      
    }

    $scope.secretaryChangeStatusBrwBook = function(borrow_id)
    {
       window.location = 'http://localhost:8080/projekuas/secretary/book_statistic/change.php?borrow_id=' + borrow_id;
    }

    $scope.secretaryChangeStatusBorrowerBook = function(data)
    {
       window.location = 'http://localhost:8080/projekuas/secretary/book_statistic/change.php?borrow_id=' + data.ID_Peminjaman; 
    }

    $scope.secretaryNotiftoBrw = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_notif_to_borrower.php",
                        data: {
                                 borrow_id : data
                              },
                              headers: {'Content-Type': 'application/json'}
                }).then(function (response) {
                    $scope.complete();
                    var res = angular.fromJson(response.data);

                     if (typeof res === "object") 
                     {
                        if (res['Type'] == 'success') 
                        {
                            swal(res['Title'], res['Message'], res['Type']);
                        }
                        else
                        {
                             swal(res['Title'], res['Message'], res['Type']);
                        }
                      }
                      else 
                      {
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengiriman notifikasi ke pengguna tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }


    $scope.secretaryNotiftoBorrower = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_notif_to_borrower.php",
                        data: {
                                 borrow_id : data.ID_Peminjaman
                              },
                              headers: {'Content-Type': 'application/json'}
                }).then(function (response) {
                    $scope.complete();
                    var res = angular.fromJson(response.data);

                     if (typeof res === "object") 
                     {
                        if (res['Type'] == 'success') 
                        {
                            swal(res['Title'], res['Message'], res['Type']);
                        }
                        else
                        {
                             swal(res['Title'], res['Message'], res['Type']);
                        }
                      }
                      else 
                      {
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengiriman notifikasi ke pengguna tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }

    $scope.secretarydelBookStatistic = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_delete_book_statistic.php",
                        data: {
                                 borrow_id : data
                              },
                              headers: {'Content-Type': 'application/json'}
                }).then(function (response) {
                    $scope.complete();
                    var res = angular.fromJson(response.data);

                     if (typeof res === "object") 
                     {
                        if (res['Type'] == 'success') 
                        {
                             swal({
                                    text: res['Message'],
                                    icon: res['Type'],
                                    showConfirmButton:true,
                                    showCancelButton:false
                            })
                            .then((confirm) => {
                                   if (confirm) {
                                    $scope.start();
                                    $window.location.reload();
                                    $scope.complete();
                                  }
                            });
                        }
                        else
                        {
                             swal(res['Title'], res['Message'], res['Type']);
                        }
                      }
                      else 
                      {
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan data peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }

    $scope.secretaryDeleteBookStatistic = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_delete_book_statistic.php",
                        data: {
                                 borrow_id : data.ID_Peminjaman
                              },
                              headers: {'Content-Type': 'application/json'}
                }).then(function (response) {
                    $scope.complete();
                    var res = angular.fromJson(response.data);

                     if (typeof res === "object") 
                     {
                        if (res['Type'] == 'success') 
                        {
                             swal({
                                    text: res['Message'],
                                    icon: res['Type'],
                                    showConfirmButton:true,
                                    showCancelButton:false
                            })
                            .then((confirm) => {
                                   if (confirm) {
                                    $scope.start();
                                    $window.location.reload();
                                    $scope.complete();
                                  }
                            });
                        }
                        else
                        {
                             swal(res['Title'], res['Message'], res['Type']);
                        }
                      }
                      else 
                      {
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan data peminjaman buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }

    $scope.errorSearchBookStatistic = function() {
       swal("Kesalahan", "ID peminjaman masih kosong", "error");
    }

    $scope.searchBookStatistic = function() {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_search_book_statistic.php",
                        data: {
                                  keyword: $scope.keyword
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
                             $scope.searchBookStatisticForm.$setPristine();
                             $scope.searchBookStatisticForm.$setUntouched();
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