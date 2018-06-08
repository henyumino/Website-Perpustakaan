var setupTreasurer = angular.module('setupTreasurerApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 setupTreasurer.controller('setupTreasurerController', function($scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.setupTreasurer = function() {

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
               url: "http://localhost:8080/projekuas/ajax/treasurer_setup.php",
               data: {
                       id               : treasurer_id,
                       password         : $scope.password,
                       confirmpassword  : $scope.confirmpassword
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
                                window.location = "http://localhost:8080/projekuas/treasurer/dashboard/";
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengaturan katasandi tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali.', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }
});
