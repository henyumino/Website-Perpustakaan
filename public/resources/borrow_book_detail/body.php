<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="usersborrowBookDetailApp" ng-controller="usersborrowBookDetailController">
 <div class="menu-atas" style="background: #ffffff !important;">
    <span><p style="margin: 30px 10px;">Halaman Pengguna</p></span>
    <div class="setting">
      <button type="submit" name="button" ng-click="GotoDashboardPage()"><i class="fa fa-cog fa-1x"></i><span>Dashboard<span></span></span></button>
      <button type="button" name="button" ng-click="GotoLogout()"><i class="fa fa-sign-out fa-1x"></i><span>Keluar<span></button>
    </div>
  </div>
  <div id="pinjam-buku-dash" style="background: #ffffff;margin-top: -20px;">
    <span class="label-dash">Buku</span>
    <span class="ket-dash">Dashboard / Buku / <?=$Variable['Data']['Judul_Buku'];?></span>
    <hr class="garis-dash">
    <!-- book place -->
    <div class="book-cover">
      <img src="<?=$Variable['URL'].'resources/assets/'.$Variable['Data']['Folder_Buku'].'/'.$Variable['Data']['Foto_Buku'];?>">
    </div>
    <div class="book-t">
      <?=$Variable['Data']['Judul_Buku'];?>
      <br>
      <span>Kategori : <a href="<?=$Variable['URL'].'dashboard/book_category.php?id='.$Variable['Data']['ID_Kategori_Buku'];?>" style="color: blue;"><?=$Variable['Data']['Kategori_Buku'];?></a></span>
    </div>
    <div class="pinjam-di">
      <span id="pinjam">Pinjam</span>
      <ng-form method="POST" name="borrowBookForm"> 
       <div ng-show="borrowBookForm.day.$touched && borrowBookForm.day.$error.required">
        <span id="durasi-pinjam">Masukkan durasi peminjaman</span>
       </div>
       <select class="pinjam-buku" name="day" ng-model="day" required>
          <option value="" selected>Pilih Durasi</option>
       </select>
       <div ng-if="borrowBookForm.$valid">
        <button type="button" name="button" ng-click="borrowBookstep2()">PINJAM</button>
       </div>
       <div ng-if="!borrowBookForm.$valid">
        <button type="button" name="button" style="cursor: not-allowed;">PINJAM</button>
       </div>
    </ng-form>
      <span id="tos-pinjam">*<b>Pemberitahuan</b> silahkan membaca mengenai <a href="#">syarat dan ketentuan</a> agar mengetahui ketentuan apa saja dalam meminjam buku</span>
      <div class="box-rating">
        <jk-rating-stars max-rating="5" rating="getRating" read-only="readOnly"></jk-rating-stars> (<a style="color: blue;" href="<?=$Variable['URL'];?>dashboard/list_review.php?book_id=<?=$Variable['Data']['ID_Buku'];?>"><?=$Variable['Jumlah_Ulasan'];?> ulasan</a>)
      </div>
    </div>
    <div class="deskripsi-buku">
      <div class="tab-des">
        <div class="tab-des-buku"><span>Deskripsi</span></div>
        <div class="tab-des-detail"><span>Detail</span></div>
      </div>
      <div class="isi-des">
        <p><?=$Variable['Data']['Deskripsi_Buku'];?></p>
      </div>
      <div class="detail-des">
        <div class="table-bunk">
          <table>
            <tr>
              <td>Judul Buku</td>
              <td><?=$Variable['Data']['Judul_Buku'];?></td>
            </tr>
            <tr>
              <td>Nama Pengarang</td>
              <td><?=$Variable['Data']['Nama_Pengarang'];?></td>
            </tr>
            <tr>
              <td>Terbitan</td>
              <td><?=$Variable['Data']['Penerbit_Buku'];?></td>
            </tr>
            <tr>
              <td>Tempat Terbit</td>
              <td><?=$Variable['Data']['Tempat_Terbit'];?></td>
            </tr>
            <tr>
              <td>Jumlah Buku saat ini</td>
              <td><?=$Variable['Data']['Jumlah_Buku'];?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="rekomendasi-buku">
      <span class="reko-title">Rekomendasi Buku</span>
         <?php
              if (empty($Variable['Buku']) == false)
              {
                 for ($i=1; $i <= count($Variable['Rekomendasi_Buku']); $i++) 
                 {
                    ?>
                      <div class="book-wh-pinjam">
                        <img src="<?=$Variable['URL'].'resources/assets/'.$Variable['Rekomendasi_Buku'][$i]['Folder_Buku'].'/'.$Variable['Rekomendasi_Buku'][$i]['Foto_Buku'];?>"/>
                       <div class="button-pinjam">
                        <a href="<?=$Variable['URL'].'dashboard/book.php?id='.$Variable['Rekomendasi_Buku'][$i]['ID_Buku'];?>"><span>PINJAM</span></a>
                       </div>
                      </div>
                    <?php
                 }
              }
              else
              {
                 ?>
                  <div style="margin-top: 50px;margin-left: 10px;">Tidak ada rekomendasi buku</div>
                 <?php
              }

         ?>
    </div>
</body>