var treasurerDashboard = angular.module('treasurerDashboardApp', ['chieffancypants.loadingBar', 'ngAnimate'])
.config(function(cfpLoadingBarProvider, $compileProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|file|javascript):/);
  })

 treasurerDashboard.controller('treasurerDashboardController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.GotoTreasureredtReport = function(report_id) {
       window.location = 'http://localhost:8080/projekuas/treasurer/dashboard/edit.php?report_id=' + report_id; 
    }

    $scope.GotoTreasurerEditReport = function(data) {
       window.location = 'http://localhost:8080/projekuas/treasurer/dashboard/edit.php?report_id=' + data.ID_Laporan; 
    }

    $scope.GotoTreasurerdelReport = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/treasurer_delete_report.php",
                        data: {
                                 report_id : data
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
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }

    $scope.GotoTreasurerDeleteReport = function(data) {
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/treasurer_delete_report.php",
                        data: {
                                 report_id : data.ID_Laporan
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
                          swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penghapusan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
                      }
                })
    }

    $scope.searchReport = function() {
      console.log($scope.year);
      $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
                $scope.start();
                $http({
                        method: "post",
                        url: "http://localhost:8080/projekuas/ajax/treasurer_search_report.php",
                        data: {
                                  month : $scope.month,
                                  year  : $scope.year
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
                             $scope.searchReportsForm.$setPristine();
                             $scope.searchReportsForm.$setUntouched();
                             $scope.showResult      = true;
                             $scope.showTableResult = true;
                             $scope.showTextResult  = false;
                             $scope.resultSearch    = res['result'];
                             $scope.getResultInfo      = res['resultInfo'];
                        }
                        else if (res['Type'] == 'no_result')
                        {
                             $scope.showResult      = true;
                             $scope.showTableResult = false;
                             $scope.no_result       = res['result'];
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

    $scope.treasurerAddReports = function() {

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
               url: "http://localhost:8080/projekuas/ajax/treasurer_add_reports.php",
               data: {
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
                    $scope.income   = '';
                    $scope.spending = '';
                    $scope.information  = '';
                    $scope.addReportsForm.$setPristine();
                    $scope.addReportsForm.$setUntouched();
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan penambahan laporan tidak berhasil. Silahkan muat ulang laman ini dan mencoba kembali', 'error');
            }
          })
        } 
        else {
            swal("Silahkan periksa kembali !");
        } 
     });
    }
});