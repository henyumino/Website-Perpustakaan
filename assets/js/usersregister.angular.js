var usersRegister = angular.module('usersRegisApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

  usersRegister.controller('usersRegisController', function($scope, $http, $timeout, cfpLoadingBar) {

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

      $scope.usersRegis = function() {
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
               url: "http://localhost:8080/projekuas/ajax/users_register.php",
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
                       password        : $scope.password,
                       confirmpassword : $scope.confirmpassword
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
            $scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
                if (res['Type'] == 'success') 
                {
                    $scope.fname           = '';
                    $scope.lname           = '';
                    $scope.dateofbirth     = '';
                    $scope.monthofbirth    = '';
                    $scope.yearofbirth     = '';
                    $scope.gender          = '';
                    $scope.address         = '';
                    $scope.phonenumber     = '';
                    $scope.email           = '';
                    $scope.password        = '';
                    $scope.confirmpassword = ''; 
                    $scope.usersRegisForm.$setPristine();
                    $scope.usersRegisForm.$setUntouched();
                    swal(res['Title'], res['Message'], res['Type']);
                }
                else 
                {
                   swal(res['Title'], res['Message'], res['Type']);
                }
            }
            else 
            {
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pendaftaran anda tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.', 'error');
            }
       })
          } 
          else {
            swal("Silahkan periksa kembali !");
          } 
        });
          }
  });