var secretaryManageCategory = angular.module('secretaryManageCategoryApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider, $compileProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|javascript):/);
  })

 secretaryManageCategory.controller('secretaryManageCategoryController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.categoryname = $window._xK12f;

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

    $scope.GotoSecretaryedtCategory = function(category_id) {
        window.location = 'http://localhost:8080/projekuas/secretary/manage_category/edit.php?category_id=' + category_id;
    }

    $scope.GotoSecretaryEditCategory = function(data) {
        window.location = 'http://localhost:8080/projekuas/secretary/manage_category/edit.php?category_id=' + data.ID_Kategori_Buku;
    }

    $scope.secretaryAddCategory = function() {

     swal({
            text: "Apakah anda sudah yakin dengan data yang anda masukkan?",
            icon: "info",
            buttons: true,
            dangerMode: false
         })
     .then((confirm) => {
      if (confirm) {
            $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/secretary_add_category.php",
               data: {
                       categoryname : $scope.categoryname
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
            $scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
                if (res['Type'] == 'success') 
                {
                    $scope.categoryname   = '';
                    $scope.addCategoryForm.$setPristine();
                    $scope.addCategoryForm.$setUntouched();
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penambahan kategori tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }

    $scope.secretaryEditCategory = function() {

     swal({
            text: "Apakah anda sudah yakin dengan data yang anda masukkan?",
            icon: "info",
            buttons: true,
            dangerMode: false
         })
     .then((confirm) => {
      if (confirm) {
            $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/secretary_edit_category.php",
               data: {
                       id           : $window._yX5cd,
                       categoryname : $scope.categoryname
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
            $scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
                if (res['Type'] == 'success') 
                {
                    $scope.categoryname   = res['new_category_name'];
                    $scope.editCategoryForm.$setPristine();
                    $scope.editCategoryForm.$setUntouched();
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengeditan kategori tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }

    $scope.searchCategory = function() {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_search_category.php",
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
                             $scope.searchCategoryForm.$setPristine();
                             $scope.searchCategoryForm.$setUntouched();
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

    $scope.errorSearchCategory = function() {
       swal("Kesalahan", "Nama kategori masih kosong", "error");
    }

    $scope.secretarydelCategory = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_delete_category.php",
                        data: {
                                 category_id : data
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
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan kategori tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }

    $scope.secretaryDeleteCategory = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/secretary_delete_category.php",
                        data: {
                                 category_id : data.ID_Kategori_Buku
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