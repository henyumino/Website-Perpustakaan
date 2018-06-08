<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="usersReviewBookApp" ng-controller="usersReviewBookController">
  <a href="<?=$Variable['URL'];?>dashboard/" style="text-decoration: none;">Halaman awal</a>
  <br/>
  Ulas buku <strong><?=$Variable['Data']['Judul_Buku'];?></strong>
  <br/><br/>
  Silahkan mengulas buku ini yang dimana sebelumnya anda sudah pernah meminjamnya. Mungkin dengan adanya ulasan anda dapat dijadikan refresensi untuk pembaca yang lainnya.
  <br/>
  <br/>
  <form method="POST" name="usersReviewBookForm">
    <tr>
      <td>
        <label>Isi Ulasan</label>
      </td>
      <td>
        <textarea name="review" ng-model="review" ng-minlength="15" ng-maxlength="500" required>
          
        </textarea> 
      </td>
      <td>
        <div ng-show="usersReviewBookForm.review.$touched && usersReviewBookForm.review.$error.required">
          <font style="color:red">Isi ulasan masih kosong</font>
        </div>
        <div ng-show="usersReviewBookForm.review.$error.minlength">
          <font style="color:red">Isi ulasan minimal 15 karakter</font>
        </div>
        <div ng-show="usersReviewBookForm.review.$error.maxlength">
          <font style="color:red">Isi ulasan maksimal 500 karakter</font>
        </div>
        <br/><br/>
    </td>
  </tr>
  <tr>
    <td>
      <label>Jumlah Rating</label>
    </td>
    <td>
      <jk-rating-stars rating="rating" required></jk-rating-stars>
      <br/><br/>
    </td>
  </tr>
  <tr>
     <td></td>
     <td>
        <div ng-if="usersReviewBookForm.$valid">
          <button type="submit" ng-click="usersReviewBook()">Review Buku</button>
        </div>
        <div ng-if="!usersReviewBookForm.$valid">
          <button type="submit" disabled>Review Buku</button>
        </div>
      </td>
  </tr>
  </form>
</body>