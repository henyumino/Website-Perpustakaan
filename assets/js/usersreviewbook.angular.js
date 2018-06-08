var usersReviewBook = angular.module('usersReviewBookApp', ['chieffancypants.loadingBar', 'jkAngularRatingStars', 'ngAnimate'])
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  })

 usersReviewBook.controller('usersReviewBookController', function($window, $scope, $http, $timeout, cfpLoadingBar) {

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

    $scope.rating = 0;

    $scope.usersReviewBook = function() 
    {
      $scope.start();
            $http({
               method: "post",
               url: "http://localhost:8080/projekuas/ajax/users_review_book.php",
               data: {
                        bookid      : $window._aFgQ1,
                        usersid     : $window._aFgQ2,
                        usersreview : $scope.review,
                        usersrating : $scope.rating
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
                          window.location = "http://localhost:8080/projekuas/dashboard/list_review.php?review_id=" + res['review_id'] + "&book_id=" + res['book_id'];
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
                swal('Kesalahan', 'Terjadi kesalahan sistem yang menyebabkan dalam mengulas buku tidak berhasil. Silahkan muat ulang laman ini dan mendaftar kembali.', 'error');
            }
    })}
});