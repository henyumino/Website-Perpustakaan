var secretaryManageBooks = angular.module('secretaryManageBooksApp', ['chieffancypants.loadingBar', 'ngAnimate', 'ngFileUpload', 'ngImgCrop'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 secretaryManageBooks.controller('secretaryManageBooksController', function($window, $scope, $http, $timeout, cfpLoadingBar, Upload) {
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

    $scope.id               = $window._jQx1f;
    $scope.booktitle        = $window._jQx2f;
    $scope.bookdescription  = $window._jQx3f;
    $scope.authorname       = $window._jQx4f;
    $scope.bookpublisher    = $window._jQx5f;
    $scope.datepublished    = $window._jQx6f;
    $scope.monthpublished   = $window._jQx7f;
    $scope.yearpublished    = $window._jQx8f;
    $scope.placepublished   = $window._jQx9f;
    $scope.bookcategory     = $window._jQx10f;
    $scope.numberofbook     = $window._jQx11f;

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

    $scope.secretaryEditBook = function(CropedBookImg, ImgFileName) {
      if ($scope.bookimg == undefined)
      {
          swal({
            text: "Apakah anda sudah yakin dengan data yang anda masukkan?",
            icon: "info",
            buttons: true,
            dangerMode: false
          })
          .then((confirm) => {
            if (confirm) {
                $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_edit_book.php",
                        data: {
                                  id                  : $scope.id,
                                  booktitle           : $scope.booktitle,
                                  bookdescription     : $scope.bookdescription,
                                  authorname          : $scope.authorname,
                                  bookpublisher       : $scope.bookpublisher,
                                  datepublished       : $scope.datepublished,
                                  monthpublished      : $scope.monthpublished,
                                  yearpublished       : $scope.yearpublished,
                                  placepublished      : $scope.placepublished,
                                  bookcategory        : $scope.bookcategory,
                                  numberofbook        : $scope.numberofbook
                              },
                              headers: {'Content-Type': 'application/json'}
                }).then(function (response) {
                    $scope.complete();
                    var res = angular.fromJson(response.data);

                     if (typeof res === "object") 
                     {
                       if (res['Type'] == 'success') 
                        {
                             $scope.booktitle         = res['new_book_title'];
                             $scope.bookdescription   = res['new_book_description'];
                             $scope.authorname        = res['new_author_name'];
                             $scope.bookpublisher     = res['new_book_publisher'];
                             $scope.datepublished     = res['new_date_published'];
                             $scope.monthpublished    = res['new_month_published'];
                             $scope.yearpublished     = res['new_year_published'];
                             $scope.placepublished    = res['new_place_published'];
                             $scope.bookcategory      = res['new_book_category'];
                             $scope.numberofbook      = res['new_number_of_book'];
                             $scope.editBookForm.$setPristine();
                             $scope.editBookForm.$setUntouched();
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
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengeditan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                  })
                }  
                else 
                {
                    swal("Silahkan periksa kembali !");
                }  
              });
           }
      else
      {
          swal({
            text: "Apakah anda sudah yakin dengan data yang anda masukkan?",
            icon: "info",
            buttons: true,
            dangerMode: false
         })
         .then((confirm) => {
            if (confirm) {
              Upload.upload({
                              url: "http://localhost:8080/projekuas/ajax/secretary_edit_book_with_upload.php",
                              method: "POST",
                              file: Upload.dataUrltoBlob(CropedBookImg, ImgFileName),
                              data: {
                                      id               : $scope.id,
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
                                    $scope.booktitle         = res['new_book_title'];
                                    $scope.bookdescription   = res['new_book_description'];
                                    $scope.authorname        = res['new_author_name'];
                                    $scope.bookpublisher     = res['new_book_publisher'];
                                    $scope.datepublished     = res['new_date_published'];
                                    $scope.monthpublished    = res['new_month_published'];
                                    $scope.yearpublished     = res['new_year_published'];
                                    $scope.placepublished    = res['new_place_published'];
                                    $scope.bookcategory      = res['new_book_category'];
                                    $scope.numberofbook      = res['new_number_of_book'];
                                    $scope.editBookForm.$setPristine();
                                    $scope.editBookForm.$setUntouched();
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
                                  swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengeditan buku tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                              }
                        })
            }
            else 
            {
               swal("Silahkan periksa kembali !");
            } 
        });
      } 
    }    
    
});