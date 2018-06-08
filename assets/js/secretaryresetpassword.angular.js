var secretaryResetPassword = angular.module('secretaryResetPasswordApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 secretaryResetPassword.controller('secretaryResetPasswordController', function($scope, $window, $http, $timeout, cfpLoadingBar) {

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

    $scope.secretaryResetPassword = function() {
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
               url: "http://localhost:8080/projekuas/ajax/secretary_reset_password.php",
               data: {
                       id       : $window._zMx1f,
                       password : $scope.password
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
            $scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
                if (res['Type'] == 'success') 
                {
                   $scope.password = '';
                   $scope.secretaryResetPasswordForm.$setPristine();
                   $scope.secretaryResetPasswordForm.$setUntouched();
                   swal({
                          text: res['Message'],
                          icon: res['Type'],
                          showConfirmButton:true,
                          showCancelButton:false
                        })
                        .then((confirm) => {
                            if (confirm) {
                              window.location = "http://localhost:8080/projekuas/secretary/dashboard/";
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan mengatur ulang katasandi anda tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }
});