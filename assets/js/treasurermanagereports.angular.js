var treasurerManageReports = angular.module('treasurerManageReportsApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 treasurerManageReports.controller('treasurerManageReportsController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.GotoAccountSettings = function() {
        window.location = 'http://localhost:8080/projekuas/treasurer/settings/'; 
    }

    $scope.GotoLogout = function() {
        window.location = 'http://localhost:8080/projekuas/treasurer/logout/';      
    }

    $scope.GotomanageReportPage = function() {
        window.location = 'http://localhost:8080/projekuas/treasurer/dashboard/';      
    }

    $scope.income       = $window._xK12f;
    $scope.spending     = $window._xK13f;
    $scope.information  = $window._xK14f;

    $scope.treasurerEditReport = function() {

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
               url: "http://localhost:8080/projekuas/ajax/treasurer_edit_report.php",
               data: {
                       id           : $window._xK11f,
                       income       : $scope.income,
                       spending     : $scope.spending,
                       information  : $scope.information
                     },
              headers: {'Content-Type': 'application/json'}
          }).then(function (response) {
            $scope.complete();
            var res = angular.fromJson(response.data);

            if (typeof res === "object") 
            {
                if (res['Type'] == 'success') 
                {
                    $scope.income   = res['new_income'];
                    $scope.spending = res['new_spending'];
                    $scope.information = res['new_information'];
                    $scope.editReportForm.$setPristine();
                    $scope.editReportForm.$setUntouched();
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan pengeditan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }
});