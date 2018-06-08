var adminDashboard = angular.module('adminDashboardApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider, $compileProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|javascript):/);
  })

 adminDashboard.controller('adminDashboardController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.GotomanageMemberPage = function() {
        window.location = 'http://localhost:8080/projekuas/admin/dashboard/index.php?secretaryList=show&treasurerList=hide'; 
    }

    $scope.GotoAccountSettings = function() {
        window.location = 'http://localhost:8080/projekuas/admin/settings/'; 
    }

    $scope.GotoLogout = function() {
        window.location = 'http://localhost:8080/projekuas/admin/logout/';      
    }

    $scope.errorSearchSecretary = function() {
      swal("Kesalahan", "Nama masih kosong", "error");
    }

    $scope.errorSearchTreasurer = function() {
      swal("Kesalahan", "Nama masih kosong", "error");
    }

    $scope.searchSecretary = function() {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/admin_search_secretary.php",
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
                             $scope.searchSecretaryForm.$setPristine();
                             $scope.searchSecretaryForm.$setUntouched();
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

    $scope.searchTreasurer = function() {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/admin_search_treasurer.php",
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
                             $scope.searchTreasurerForm.$setPristine();
                             $scope.searchTreasurerForm.$setUntouched();
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

    $scope.admindelRoleSecretary = function(secretary_id) {
      $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/admin_delete_role_secretary.php",
               data: {
                       secretary_id: secretary_id
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
                                    confirm:true,
                                    cancel:false
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
    }

    $scope.adminDeleteRoleSecretary = function(secretary_id) {
      $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/admin_delete_role_secretary.php",
               data: {
                       secretary_id: secretary_id.ID_Sekretaris
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
                                    confirm:true,
                                    cancel:false
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
    }

    $scope.admindelRoleTreasurer = function(treasurer_id) {
      $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/admin_delete_role_treasurer.php",
               data: {
                       treasurer_id: treasurer_id
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
                                    confirm:true,
                                    cancel:false
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
    }

    $scope.adminDeleteRoleTreasurer = function(treasurer_id) {
      $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/admin_delete_role_treasurer.php",
               data: {
                       treasurer_id: treasurer_id.ID_Bendahara
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
                                    confirm:true,
                                    cancel:false
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
    }

    $scope.adminAddMember = function() {

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
               url: "http://localhost:8080/projekuas/ajax/admin_add_member.php",
               data: {
                       firstname       : $scope.fname,
                       lastname        : $scope.lname,
                       dateofbirth     : $scope.dateofbirth,
                       monthofbirth    : $scope.monthofbirth,
                       yearofbirth     : $scope.yearofbirth,
                       gender          : $scope.gender,
                       address         : $scope.address,
                       phonenumber     : $scope.phonenumber,
                       email           : $scope.email,
                       role            : $scope.role
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
            $scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
                if (res['Type'] == 'success') 
                {
                    $scope.fname         = '';
                    $scope.lname         = '';
                    $scope.dateofbirth   = '';
                    $scope.monthofbirth  = '';
                    $scope.yearofbirth   = '';
                    $scope.gender        = '';
                    $scope.address       = '';
                    $scope.phonenumber   = '';
                    $scope.email         = '';
                    $scope.role          = '';
                    $scope.addMemberForm.$setPristine();
                    $scope.addMemberForm.$setUntouched();
                    swal(res['Title'], res['Message'], res['Type']);
                }
                else
                {
                  swal(res['Title'], res['Message'], res['Type']);
                }
            }
            else 
            {
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penambahan anggota tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }
});