var secretaryLogin = angular.module('secretaryLoginApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 secretaryLogin.controller('secretaryLoginController', function($scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.scrLogin = function() {

     var loginMethod = null;

     if ($scope.remember_me == true)
     {
     	  loginMethod = 'cookie';
     }
     else if ($scope.remember_me == undefined)
     {
     	  loginMethod = 'session';
     }
     else
     {
     	  loginMethod = 'session';
     }


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
               url: "http://localhost:8080/projekuas/ajax/secretary_login.php",
               data: {
                       email    : $scope.email,
                       password : $scope.password,
                       method   : loginMethod
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
          	$scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
            	  if (res['Type'] == 'success') 
                {
                   window.location = "http://localhost:8080/projekuas/secretary/dashboard/";
                }
                else
                {
                	swal(res['Title'], res['Message'], res['Type']);
                }
            }
            else 
            {
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan proses login anda tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }
});