var secretaryChangeStatusBookBorrower = angular.module('secretaryChangeStatusBookBorrowerApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 secretaryChangeStatusBookBorrower.controller('secretaryChangeStatusBookBorrowerController', function($window, $scope, $http, $timeout, cfpLoadingBar) {
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

    $scope.optionType1              = [
                                        {id: 0, label: 'Proses Peminjaman'},
                                        {id: 1, label: 'Dipinjam' },
                                        {id: 2, label: 'Dikembalikan', disabled: true}  
                                      ];

    $scope.borrowedStatusType1      = $scope.optionType1[0];

    $scope.optionType2              = [
                                        {id: 0, label: 'Dipinjam' },
                                        {id: 1, label: 'Dikembalikan'},
                                        {id: 2, label: 'Proses Peminjaman', disabled: true}  
                                      ];

    $scope.borrowedStatusType2      = $scope.optionType2[0];

    $scope.optionType3              = [
                                        {id: 0, label: 'Dikembalikan'},
                                        {id: 1, label: 'Proses Peminjaman', disabled: true},  
                                        {id: 2, label: 'Dipinjam', disabled: true}
                                      ];

    $scope.borrowedStatusType3      = $scope.optionType3[0];

     $scope.secretaryChangeStatusBookBorrowerType1 = function() {
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
                            url: "http://localhost:8080/projekuas/ajax/secretary_change_status_book_borrower.php",
                            data: {
                                     borrow_id       : $window._xMx1f,
                                     bookid          : $window._spc2x,
                                     booktitle       : $window._xMx2f,
                                     borrowed_date   : $window._xMx3f,
                                     returned_date   : $window._xMx4f,
                                     borrower_email  : $window._xMx5f,
                                     borrower_name   : $window._xMx6f,
                                     oldStatus       : $window._spc1x,
                                     newStatus       : $scope.borrowedStatusType1
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
                      swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                    }
                })
              } 
              else {
                swal("Silahkan periksa kembali !");
            }    
        });
      } 

      $scope.secretaryChangeStatusBookBorrowerType2 = function() {
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
                            url: "http://localhost:8080/projekuas/ajax/secretary_change_status_book_borrower.php",
                            data: {
                                     borrow_id       : $window._xMx1f,
                                     bookid          : $window._spc2x,
                                     booktitle       : $window._xMx2f,
                                     borrowed_date   : $window._xMx3f,
                                     returned_date   : $window._xMx4f,
                                     borrower_email  : $window._xMx5f,
                                     borrower_name   : $window._xMx6f,
                                     oldStatus       : $window._spc1x,
                                     newStatus       : $scope.borrowedStatusType2
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
                      swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengubahan status peminjaman tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                    }
                })
              } 
              else {
                swal("Silahkan periksa kembali !");
            }    
        });
      } 
});