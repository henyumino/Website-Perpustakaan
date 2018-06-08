var secretaryDashboard = angular.module('secretaryDashboardApp', ['chieffancypants.loadingBar', 'ngAnimate', 'ngFileUpload', 'ngImgCrop'])
.config(function(cfpLoadingBarProvider, $compileProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|javascript):/);
  })

 secretaryDashboard.controller('secretaryDashboardController', function($window, $scope, $http, $timeout, cfpLoadingBar, Upload) {

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

    $scope.GotoSecretaryedtBook = function(book_id) {
        window.location = 'http://localhost:8080/projekuas/secretary/dashboard/edit.php?book_id=' + book_id;
    }

    $scope.GotoSecretaryEditBook = function(data) {
        window.location = 'http://localhost:8080/projekuas/secretary/dashboard/edit.php?book_id=' + data.ID_Buku;
    }


    $scope.secretarydelBook = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_delete_book.php",
                        data: {
                                 book_id : data
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
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }

    $scope.secretaryAddBook = function(CropedBookImg, ImgFileName) {
     swal({
            text: "Apakah anda sudah yakin dengan data yang anda masukkan?",
            icon: "info",
            buttons: true,
            dangerMode: false
         })
     .then((confirm) => {
      if (confirm) {
        Upload.upload({
            url: "http://localhost:8080/projekuas/ajax/secretary_add_book.php",
            method: "POST",
            file: Upload.dataUrltoBlob(CropedBookImg, ImgFileName),
            data: {
                      booktitle        : $scope.booktitle,
                      bookdescription  : $scope.bookdescription,
                      authorname       : $scope.authorname,
                      bookpublisher    : $scope.bookpublisher,
                      datepublished    : $scope.datepublished,
                      monthpublished   : $scope.monthpublished,
                      yearpublished    : $scope.yearpublished,
                      placepublished   : $scope.placepublished,
                      bookcategory     : $scope.bookcategory,
                      numberofbook     : $scope.numberofbook
                  }
        }).then(function (response) {
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penambahan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
        })}
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }

    $scope.searchBook = function() {
       $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_search_book.php",
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
                             $scope.searchBookForm.$setPristine();
                             $scope.searchBookForm.$setUntouched();
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

    $scope.errorSearchBook = function() {
       swal("Kesalahan", "Judul buku masih kosong", "error");
    }

    $scope.secretaryDeleteBook = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_delete_book.php",
                        data: {
                                 book_id : data.ID_Buku
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
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }
});