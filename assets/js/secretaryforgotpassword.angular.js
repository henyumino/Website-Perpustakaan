var secretaryForgotPassword = angular.module('secretaryForgotPasswordApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 secretaryForgotPassword.controller('secretaryForgotPasswordController', function($scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.secretaryForgotPassword = function() {
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
               url: "http://localhost:8080/projekuas/ajax/secretary_forgot_password.php",
               data: {
                       email    : $scope.email
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
          	$scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
            	  if (res['Type'] == 'success') 
                {
                   $scope.email = '';
                   $scope.secretaryForgotPasswordForm.$setPristine();
                   $scope.secretaryForgotPasswordForm.$setUntouched();
                   swal(res['Title'], res['Message'], res['Type']);   
                }
                else
                {
                	swal(res['Title'], res['Message'], res['Type']);
                }
            }
            else 
            {
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan proses permintaan ulang katasandi anda tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }
});