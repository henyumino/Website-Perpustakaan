var usersAccountSettings = angular.module('usersAccountSettingsApp', ['chieffancypants.loadingBar', 'ngAnimate', 'ngFileUpload', 'ngImgCrop'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 usersAccountSettings.controller('usersAccountSettingsController', function($window, $scope, $http, $timeout, cfpLoadingBar, Upload) {
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

    $scope.id               = $window._xMx1f;
    $scope.fullname         = $window._xMx2f;
    $scope.dateofbirth      = $window._xMx3f;
    $scope.monthofbirth     = $window._xMx4f;
    $scope.yearofbirth      = $window._xMx5f;
    $scope.gender           = $window._xMx6f;
    $scope.address          = $window._xMx7f;
    $scope.phonenumber      = $window._xMx8f;
    $scope.email            = $window._xMx9f;

    $scope.GotoDashboardPage = function() {
        window.location = 'http://localhost:8080/projekuas/dashboard/';
    }

    $scope.GotoLogout = function() {
        window.location = 'http://localhost:8080/projekuas/logout/';      
    }

    $scope.usersEditAccount = function(croppedprofilepicture, profilepicturename) {
      if ($scope.profilepicture == undefined)
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
                        url: "http://localhost:8080/projekuas/ajax/users_update_account_informations.php",
                        data: {
                                 id            : $scope.id,
                                 fullname      : $scope.fullname,
                                 dateofbirth   : $scope.dateofbirth,
                                 monthofbirth  : $scope.monthofbirth,
                                 yearofbirth   : $scope.yearofbirth,
                                 gendernow     : $window._xMx5f,
                                 gender        : $scope.gender,
                                 address       : $scope.address,
                                 phonenumber   : $scope.phonenumber,
                                 email         : $scope.email
                              },
                              headers: {'Content-Type': 'application/json'}
                }).then(function (response) {
                    $scope.complete();
                    var res = angular.fromJson(response.data);

                     if (typeof res === "object") 
                     {
                       if (res['Type'] == 'success') 
                        {
                             $scope.fullname      = res['new_data']['fullname'];
                             $scope.dateofbirth   = res['new_data']['dateofbirth'];
                             $scope.monthofbirth  = res['new_data']['monthofbirth'];
                             $scope.yearofbirth   = res['new_data']['yearofbirth'];
                             $scope.gender        = res['new_data']['gender'];
                             $scope.address       = res['new_data']['address'];
                             $scope.phonenumber   = res['new_data']['phonenumber'];
                             $scope.usersEditAccountForm.$setPristine();
                             $scope.usersEditAccountForm.$setUntouched();
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
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengeditan akun tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
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
                              url: "http://localhost:8080/projekuas/ajax/users_update_account_informations_with_upload.php",
                              method: "POST",
                              file: Upload.dataUrltoBlob(croppedprofilepicture, profilepicturename),
                              data: {
                                      id            : $scope.id,
                                      fullname      : $scope.fullname,
                                      dateofbirth   : $scope.dateofbirth,
                                      monthofbirth  : $scope.monthofbirth,
                                      yearofbirth   : $scope.yearofbirth,
                                      gender        : $scope.gender,
                                      address       : $scope.address,
                                      phonenumber   : $scope.phonenumber,
                                      email         : $scope.email
                                    }
                           }).then(function (response) {
                                var res = angular.fromJson(response.data);

                               if (typeof res === "object") 
                               {
                                  if (res['Type'] == 'success') 
                                  {
                                    $scope.fullname      = res['new_data']['fullname'];
                                    $scope.dateofbirth   = res['new_data']['dateofbirth'];
                                    $scope.monthofbirth  = res['new_data']['monthofbirth'];
                                    $scope.yearofbirth   = res['new_data']['yearofbirth'];
                                    $scope.gender        = res['new_data']['gender'];
                                    $scope.address       = res['new_data']['address'];
                                    $scope.phonenumber   = res['new_data']['phonenumber'];
                                    $scope.usersEditAccountForm.$setPristine();
                                    $scope.usersEditAccountForm.$setUntouched();
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
     $scope.usersChangePassword = function() {
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
                            url: "http://localhost:8080/projekuas/ajax/users_change_password.php",
                            data: {
                                    id           : $scope.id,
                                    password     : $scope.password,
                                    newpassword  : $scope.newpassword
                                  },
                                  headers: {'Content-Type': 'application/json'}
                          }).then(function (response) {
                    $scope.complete();
                    var res = angular.fromJson(response.data);

                    if (typeof res === "object") 
                    {
                      if (res['Type'] == 'success') 
                      {
                        $scope.password     = '';
                        $scope.newpassword  = '';
                        $scope.usersChangePasswordForm.$setPristine();
                        $scope.usersChangePasswordForm.$setUntouched();
                        swal(res['Title'], res['Message'], res['Type']);
                      }
                      else
                      {
                        swal(res['Title'], res['Message'], res['Type']);
                      }
                    }
                    else 
                    {
                      swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengubahan katasandi tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                    }
                })
              } 
              else {
                swal("Silahkan periksa kembali !");
            }    
        });
      } 
});