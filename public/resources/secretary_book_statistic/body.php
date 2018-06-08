<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="secretaryBookStatisticApp" ng-controller="secretaryBookStatisticController">
	<div class="side-menu">
    <div class="profile-box-sekre">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Sekretaris']['Folder_Sekretaris'];?>/<?=$Variable['Data_Sekretaris']['Foto_Sekretaris'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Sekretaris']['Nama'];?></span>
      <span>Sekretaris</span>
    </div>
    <div class="cat">MAIN</div>
    <ul>
      <li id="nav1" style="background:#333645;">
        <div class="menu-nav">
          <div class="icon-nav"><img src="<?=$Variable['URL'];?>resources/assets/icon/kelola-buku.png"/></div>
          <div class="ket-nav" ng-click="GotomanageBookPage()">Kelola Buku</div>
        </div>
      </li>
      <li id="nav3" style="background:#333645;">
        <div class="menu-nav">
          <div class="icon-nav"><i class="fa fa-tags fa-1x"></i></div>
          <div class="ket-nav" ng-click="GotomanageCategoryPage()">Kelola Kategori</div>
        </div>
      </li>
      <li id="nav2" style="background:#1e202c;">
        <div class="menu-nav">
          <div class="icon-nav"><i class="fa fa-bar-chart fa-1x"></i></div>
          <div class="ket-nav" ng-click="GotoBookStatisticPage()">Statistik Buku</div>
        </div>
      </li>
    </ul>
  </div>
  <div class="menu-atas">
    <i class="fa fa-bars fa-2x" id="toggle-button"></i>
    <span>Halaman Sekretaris</span>
    <div class="setting">
      <button type="button" name="button" ng-click="GotoAccountSettings()"><i class="fa fa-cog fa-1x"></i><span>Pengaturan<span></button>
      <button type="button" name="button" ng-click="GotoLogout()"><i class="fa fa-sign-out fa-1x"></i><span>Keluar<span></button>
    </div>
  </div>
  <div class="main-dash" id="kelola-buku">
    <span class="label-dash">Statistik Buku</span>
    <span class="ket-dash">Dashboard / Statistik Buku</span>
    <ng-form method="POST" name="searchBookStatisticForm"> 
     <div class="main-tab">
        <div class="search-cat">
          <i class="fa fa-search fa-2x" ng-click="searchBookStatisticForm.$valid ? searchBookStatistic() : errorSearchBookStatistic()"></i>
            <input placeholder="Cari Buku Berdasarkan ID Peminjaman" type="text" name="keyword" ng-model="keyword" required>
      </div>
       </div>
      <div ng-show="searchBookStatisticForm.keyword.$touched && searchBookStatisticForm.keyword.$error.required">
      <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
          Kata kunci masih kosong
        </font>
    </div>
    </ng-form>
    <hr class="garis-dash">
      <div class="list-buku">
        <?php
        if (empty($Variable['List_Statistik_Buku']) == false)
        {
          ?>
             <table align="center">
               <tr>
                  <td>ID Peminjaman</td>
                  <td>Judul Buku</td>
                  <td>Tanggal Dipinjam</td>
                  <td>Tanggal Dikembalikan</td>
                  <td>Peminjam</td>
                  <td>Keterangan</td>
                  <td>Aksi</td>
               </tr>
          <?php
               for ($i=1; $i <= count($Variable['List_Statistik_Buku']); $i++) 
               {  
            ?>
                <tr>
                    <td>
                        <?=$Variable['List_Statistik_Buku'][$i]['ID_Peminjaman'];?>
                   </td>
                    <td>
                        <?=$Variable['List_Statistik_Buku'][$i]['Judul_Buku'];?>
                    </td>
                    <td>
                        <?=date("d-m-Y H:i", strtotime($Variable['List_Statistik_Buku'][$i]['Tanggal_Dipinjam']));?>
                    </td>
                    <td>
                        <?=date("d-m-Y H:i", strtotime($Variable['List_Statistik_Buku'][$i]['Tanggal_Dikembalikan']));?>
                    </td>
                    <td>
                        <?=$Variable['List_Statistik_Buku'][$i]['Nama'];?>
                    </td>
                    <td>
                        <?=$Variable['List_Statistik_Buku'][$i]['Keterangan'];?>
                    </td>
                    <td>
                        <a href="javascript:void(0)" ng-click="secretaryNotiftoBrw('<?=$Variable['List_Statistik_Buku'][$i]['ID_Peminjaman'];?>')" style="color:blue;" class="toolhov">Notif <div class="tooltip"><i class="fa fa-info-circle"></i> Kirim pemberitahuan pengembalian buku</div></a> | <a href="javascript:void(0)" ng-click="secretaryChangeStatusBrwBook('<?=$Variable['List_Statistik_Buku'][$i]['ID_Peminjaman'];?>')" style="color:blue;">Ubah Status Peminjaman</a> | <a href="javascript:void(0)" ng-click="secretarydelBookStatistic('<?=$Variable['List_Statistik_Buku'][$i]['ID_Peminjaman'];?>')" style="color:blue;">Hapus Data Peminjaman</a>
                    </td>
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
             <div class="not-table">
          <span>Tidak ada buku yang dapat ditampilkan</span>
          </div>
          <?php
        }
    ?>
 </table>
     <center>
      <?php
              if ($Variable['Halaman_Paging'] < $Variable['Total_Halaman'])
              {
                ?> <a href="<?=$Variable['URL'].'secretary/book_statistic/?page='.($Variable['Halaman_Paging']+1);?>" style="color: blue;">Selanjutnya</a> <?php
              }
              else
              {
                 
              }

              if ($Variable['Halaman_Paging'] > $Variable['Total_Halaman'] OR $Variable['Halaman_Paging'] == 1)
              {
               
              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'secretary/book_statistic/?page='.($Variable['Halaman_Paging']-1);?>" style="color: blue;">Sebelumnya</a> <?php
              } 
      ?>
    </center>
  </div>
<div ng-model="showResult" ng-show="showResult == true">
    <div ng-model="showTableResult" ng-show="showTableResult == true">
     <hr class="garis-dash">
      <div ng-model="getKeyword"><p style="margin-top: 15px;margin-left: 32px;width: 95%;">Hasil pencarian <strong>{{getKeyword}}</strong></p></div>
      <div class="list-buku">
        <table>
             <tr>
                <td>ID Peminjaman</td>
                <td>Judul Buku</td>
                <td>Tanggal Dipinjam</td>
                <td>Tanggal Dikembalikan</td>
                <td>Peminjam</td>
                <td>Keterangan</td>
                <td>Aksi</td>
              </tr>
              <tr ng-repeat="data in resultSearch">
                <td>{{data.ID_Peminjaman}}</td>
                <td>{{data.Judul_Buku}}</td>
                <td>{{data.Tanggal_Dipinjam}}</td>
                <td>{{data.Tanggal_Dikembalikan}}</td>
                <td>{{data.Peminjam}}</td>
                <td>{{data.Keterangan}}</td>
                <td><a ng-href="javascript:void(0)" ng-click="secretaryNotiftoBorrower(data)" style="color:blue;" class="toolhov">Notif <div class="tooltip"><i class="fa fa-info-circle"></i> Kirim pemberitahuan pengembalian buku</div></a> | <a ng-href="javascript:void(0)" ng-click="secretaryChangeStatusBorrowerBook(data)" style="color:blue;">Ubah Status Peminjaman</a> | <a ng-href="javascript:void(0)" ng-click="secretaryDeleteBookStatistic(data)" style="color:blue;">Hapus Data Peminjaman</a></td>
              </tr>
            </table>
      </div>
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