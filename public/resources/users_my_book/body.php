<body ng-app="usersMyBookApp" ng-controller="usersMyBookController">
  <div class="side-menu">
    <div class="profile-box">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Pengguna']['Folder_Pengguna'];?>/<?=$Variable['Data_Pengguna']['Foto_Pengguna'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Pengguna']['Nama'];?></span>
      <span>Pengguna</span>
    </div>
    <!-- menu -->
    <div class="cat">MAIN</div>
    <ul>
      <li id="nav1" style="background:#333645;">
        <div class="menu-nav">
          <div class="icon-nav"><img src="<?=$Variable['URL'];?>resources/assets/icon/book.png"/></div>
          <div class="ket-nav" ng-click="GotoBookPage()">Buku</div>
        </div>
      </li>
      <li id="nav2" style="background:#1e202c;">
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
  <div class="main-dash" id="kelola-buku">
    <span class="label-dash">Buku Saya</span>
    <span class="ket-dash">Dashboard / Buku Saya</span>
    <ng-form method="POST" name="searchBorrowedBookForm"> 
     <div class="main-tab">
        <div class="search-cat">
          <i class="fa fa-search fa-2x" ng-click="searchBorrowedBookForm.$valid ? searchBorrowedBook() : errorsearchBorrowedBook()"></i>
            <input placeholder="Cari Buku Berdasarkan Judul" type="text" name="keyword" ng-model="keyword" required>
      </div>
       </div>
      <div ng-show="searchBorrowedBookForm.keyword.$touched && searchBorrowedBookForm.keyword.$error.required">
      <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
          Kata kunci masih kosong
        </font>
    </div>
    </ng-form>
    <hr class="garis-dash">
    <div class="list-buku">
    <?php 
      if (empty($Variable['List_Buku']) == false)
        {
          ?>

          <table>
             <tr>
              <td>ID Peminjaman</td>
              <td>Judul Buku</td>
              <td>Tanggal Dipinjam</td>
              <td>Tanggal DIkembalikan</td>
              <td>Keterangan</td>
              </tr>
       <?php
          for ($i=1; $i <= count($Variable['List_Buku']); $i++) 
            {
    ?>     <tr>
              <td><?=$Variable['List_Buku'][$i]['ID_Peminjaman'];?></td>
              <td><?=$Variable['List_Buku'][$i]['Judul_Buku'];?></td>
              <td><?=$Variable['List_Buku'][$i]['Tanggal_Dipinjam'];?></td>
              <td><?=$Variable['List_Buku'][$i]['Tanggal_Dikembalikan'];?></td>
            <td><?=$Variable['List_Buku'][$i]['Keterangan'];?></td>
          </tr>
    <?php
         }
     ?> 
            </table>
      <?php 
      }
      else
      {
    ?>
          <div style="margin-top: 100px;">
          <center>Tidak ada buku dipinjam yang dapat ditampilkan</center>
          </div>
    <?php
      }
    ?>
    <div class="pagging">
    <?php
              if ($Variable['Halaman_Paging'] < $Variable['Total_Halaman'])
              {
                ?> <a href="<?=$Variable['URL'].'dashboard/my_book/index.php?page='.($Variable['Halaman_Paging']+1);?>" style="color: blue;">Selanjutnya</a> <?php
              }
              else
              {

              }

              if ($Variable['Halaman_Paging'] > $Variable['Total_Halaman'] OR $Variable['Halaman_Paging'] == 1)
              {

              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'dashboard/my_book/index.php?page='.($Variable['Halaman_Paging']-1);?>" style="color: blue;">Sebelumnya</a> <?php
              } 
      ?>
      </div>
      <div ng-model="showResult" ng-show="showResult == true">
    <div ng-model="showTableResult" ng-show="showTableResult == true">
     <hr class="garis-dash">
      <div ng-model="getKeyword"><p style="margin-top: 15px;margin-left: 32px;width: 95%;">Hasil pencarian <strong>{{getKeyword}}</strong></p></div>
        <table>
             <tr>
              <td>ID Peminjaman</td>
              <td>Judul Buku</td>
              <td>Tanggal Dipinjam</td>
              <td>Tanggal DIkembalikan</td>
              <td>Keterangan</td>
            </tr>
            <tr ng-repeat="data in resultSearch">
              <td>{{data.ID_Peminjaman}}</td>
              <td>{{data.Judul_Buku}}</td>
              <td>{{data.Tanggal_Dipinjam}}</td>
              <td>{{data.Tanggal_Dikembalikan}}</td>
              <td>{{data.Keterangan}}</td>
            </tr>
        </table>
    </div>
  </div>
  <div ng-model="showTextResult" ng-show="showTextResult == true">
   <hr class="garis-dash">
     <div ng-model="no_result">
       <p style="margin-top: 15px;margin-left: 32px;width: 95%;">Tidak ada hasil untuk <strong>{{no_result}}</strong></p>
     </div>
    </div>
  </div>
</body>