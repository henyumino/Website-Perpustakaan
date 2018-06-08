<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="usersListBookReviewApp" ng-controller="usersListBookReviewController">
  <div class="side-menu">
    <div class="profile-box">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Pengguna']['Folder_Pengguna'];?>/<?=$Variable['Data_Pengguna']['Foto_Pengguna'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Pengguna']['Nama'];?></span>
      <span>Pengguna</span>
    </div>
    <!-- menu -->
    <div class="cat">MAIN</div>
    <ul>
      <li id="nav1">
        <div class="menu-nav">
          <div class="icon-nav"><img src="<?=$Variable['URL'];?>resources/assets/icon/book.png"/></div>
          <div class="ket-nav" ng-click="GotoBookPage()">Buku</div>
        </div>
      </li>
      <li id="nav2">
        <div class="menu-nav">
          <div class="icon-nav"><img src="<?=$Variable['URL'];?>resources/assets/icon/book.png"/></div>
          <div class="ket-nav" ng-click="GotoMyBookPage()">Buku Saya</div>
        </div>
      </li>
    </ul>
  </div>
  <div class="menu-atas">
    <i class="fa fa-bars fa-2x" id="toggle-button"></i>
    <span>Halaman Pengguna</span>
    <div class="setting">
      <button type="button" name="button" ng-click="GotoAccountSettings()"><i class="fa fa-cog fa-1x"></i><span>Pengaturan<span></button>
      <button type="button" name="button" ng-click="GotoLogout()"><i class="fa fa-sign-out fa-1x"></i><span>Keluar<span></button>
    </div>
  </div>
  <div class="main-dash" id="review-buku">
    <span class="label-dash">Review Buku</span>
    <span class="ket-dash">Dashboard / Review Buku</span>
    <hr class="garis-dash">
    <span class="book-title-review"><?=$Variable['Data_Buku']['Judul_Buku'];?></span>
    <span class="cat-book-review">Kategori : <a href="<?=$Variable['URL'].'dashboard/book_category.php?id='.$Variable['Data_Buku']['ID_Kategori_Buku'];?>" style="color: blue;text-decoration: none;"><?=$Variable['Data_Buku']['Kategori_Buku'];?></a></span>
    <div class="book-image-r">
        <img src="<?=$Variable['URL'].'resources/assets/'.$Variable['Data_Buku']['Folder_Buku'].'/'.$Variable['Data_Buku']['Foto_Buku'];?>">
    </div>
    <table class="book-info-r">
        <tr>
            <td>Judul Buku</td>
            <td>:</td>
            <td><?=$Variable['Data_Buku']['Judul_Buku'];?></td>
        </tr>
        <tr>
            <td>Nama Pengarang</td>
            <td>:</td>
            <td><?=$Variable['Data_Buku']['Nama_Pengarang'];?></td>
        </tr>
        <tr>
            <td>Penerbit Buku</td>
            <td>:</td>
            <td><?=$Variable['Data_Buku']['Penerbit_Buku'];?></td>
        </tr>
        <tr>
            <td>Terbitan</td>
            <td>:</td>
            <td><?=$Variable['Data_Buku']['Penerbit_Buku'];?></td>
        </tr>
        <tr>
            <td>Tempat Terbit</td>
            <td>:</td>
            <td><?=$Variable['Data_Buku']['Tempat_Terbit'];?></td>
        </tr>
        <tr>
            <td>Jumlah Buku saat ini</td>
            <td>:</td>
            <td><?=$Variable['Data_Buku']['Jumlah_Buku'];?></td>
        </tr>
    </table>
    <div class="while-review">
        <div class="tab-des-buku">
            <span class="tab-title-r">Review</span>
        </div>
        <div class="user-review-box-none">
           
        </div>
        <?php

        if (empty($Variable['Ulasan']) == false)
        {
          for ($i=1; $i <= count($Variable['Ulasan']); $i++) 
          {  
            ?>
                <div class="user-review-box">
                   <div class="user-name-review"><?=$Variable['Ulasan'][$i]['Nama'];?></div>
                   <div class="star-rating-r">
                     <?php 
                        if ($Variable['Ulasan'][$i]['Jumlah_Rating'] == 1)
                        {
                           ?> <jk-rating-stars rating="first" read-only="readOnly"></jk-rating-stars> <?php
                        }
                        else if ($Variable['Ulasan'][$i]['Jumlah_Rating'] == 2)
                        {
                           ?> <jk-rating-stars rating="second" read-only="readOnly"></jk-rating-stars> <?php 
                        }
                        else if ($Variable['Ulasan'][$i]['Jumlah_Rating'] == 3)
                        {
                           ?> <jk-rating-stars rating="third" read-only="readOnly"></jk-rating-stars> <?php 
                        }
                        else if ($Variable['Ulasan'][$i]['Jumlah_Rating'] == 4)
                        {
                           ?> <jk-rating-stars rating="fourth" read-only="readOnly"></jk-rating-stars> <?php 
                        }
                        else if ($Variable['Ulasan'][$i]['Jumlah_Rating'] == 5)
                        {
                           ?> <jk-rating-stars rating="five" read-only="readOnly"></jk-rating-stars> <?php 
                        }

                    ?>
                   </div>
                   <div class="date-r"><?=$Variable['Ulasan'][$i]['Tanggal_Diulas'];?></div>
                   <div class="core-review"><?=$Variable['Ulasan'][$i]['Isi_Ulasan'];?></div>
                </div>
                <div class="pagging-r">
            <?php

          }

            if ($Variable['Halaman_Paging'] < $Variable['Total_Halaman'])
              {
                ?> <a href="<?=$Variable['URL'].'secretary/book_statistic/?page='.($Variable['Halaman_Paging']+1);?>" style="color: blue;text-decoration: none;">Selanjutnya</a> <?php
              }
              else
              {
                
              }

              if ($Variable['Halaman_Paging'] > $Variable['Total_Halaman'] OR $Variable['Halaman_Paging'] == 1)
              {
                
              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'secretary/book_statistic/?page='.($Variable['Halaman_Paging']-1);?>" style="color: blue;text-decoration: none;">Sebelumnya</a> <?php
              }
        }
        else
        {
           ?> 
             <div style="margin-top: 100px;text-align: center;">Tidak ada ulasan buku yang dapat ditampilkan</div>
          <?php
        }
                
      ?>
    </div>
  </div>
</body>