<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="secretaryChangeStatusBookBorrowerApp" ng-controller="secretaryChangeStatusBookBorrowerController">
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
  <div class="form-buku" style="width:50%;margin:10px 0 50px 15%;display:block;position:relative">
    <span class="label-dash">Ubah Status Peminjaman</span>
    <br/>
    <p style="margin-left:30px;margin-right: 30px;margin-bottom: -25px;">Silahkan untuk mengubah status peminjaman buku yang berjudul <strong><?=$Variable['Data_Edit']['Judul_Buku'];?></strong></strong> yang dipinjam oleh pengguna <strong><?=$Variable['Data_Edit']['Nama'];?></strong>. Silahkan pilih status peminjaman terbaru dengan menggunakan form dibawah ini. Status yang dapat diubah ialah dari status Proses Peminjaman ke Dipinjam dan Dipinjam ke Dikembalikan.</p><br/><br/>
   <form method="POST" name="secretaryChangeStatusBookBorrowerForm">
    <?php
      if ($Variable['Data_Edit']['Keterangan'] == 'Proses Peminjaman')
      {
        ?>
            <select id="change-status" name="borrowedStatusType1" ng-model="borrowedStatusType1" ng-options="item as item.label disable when item.disabled for item in optionType1"></select>        
            <div ng-show="secretaryChangeStatusBookBorrowerForm.borrowedStatusType1.$touched && secretaryChangeStatusBookBorrowerForm.borrowedStatusType1.$error.required">
              <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">Status peminjaman masih kosong</font>
            </div>
        <?php
      }
      else if ($Variable['Data_Edit']['Keterangan'] == 'Dipinjam')
      {
        ?>
            <select id="change-status" name="borrowedStatusType2" ng-model="borrowedStatusType2" ng-options="item as item.label disable when item.disabled for item in optionType2"></select>
            <div ng-show="secretaryChangeStatusBookBorrowerForm.borrowedStatusType2.$touched && secretaryChangeStatusBookBorrowerForm.borrowedStatusType2.$error.required">
              <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">Status peminjaman masih kosong</font>
            </div>
        <?php
      }
      else if ($Variable['Data_Edit']['Keterangan'] == 'Dikembalikan')
      {
        ?>
            <select id="change-status" name="borrowedStatusType3" ng-model="borrowedStatusType3" ng-options="item as item.label disable when item.disabled for item in optionType3"></select>        
            <div ng-show="secretaryChangeStatusBookBorrowerForm.borrowedStatusType3.$touched && secretaryChangeStatusBookBorrowerForm.borrowedStatusType3.$error.required">
              <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">Status peminjaman masih kosong</font>
            </div>
        <?php
      }
      else if ($Variable['Data_Edit']['Keterangan'] == 'Diulas')
      {
        ?>
            <select id="change-status" name="borrowedStatusType3" ng-model="borrowedStatusType3" ng-options="item as item.label disable when item.disabled for item in optionType3"></select>
            <div ng-show="secretaryChangeStatusBookBorrowerForm.borrowedStatusType3.$touched && secretaryChangeStatusBookBorrowerForm.borrowedStatusType3.$error.required">
              <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">Status peminjaman masih kosong</font>
            </div>
        <?php
      }
      ?>
      <div ng-show="secretaryChangeStatusBookBorrowerForm.$valid"> 
        <?php
            if ($Variable['Data_Edit']['Keterangan'] == 'Proses Peminjaman')
            {
              ?> <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;" ng-click="secretaryChangeStatusBookBorrowerType1()">Ubah Status</button>
              <?php
            }
            else if ($Variable['Data_Edit']['Keterangan'] == 'Dipinjam')
            {
              ?> <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;" ng-click="secretaryChangeStatusBookBorrowerType2()">Ubah Status</button>
              <?php
            }
            else if ($Variable['Data_Edit']['Keterangan'] == 'Dikembalikan')
            {
              ?> <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;" disabled>Ubah Status</button>
              <?php
            }
            else if ($Variable['Data_Edit']['Keterangan'] == 'Diulas')
            {
              ?> <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;" disabled>Ubah Status</button>
              <?php
            }
        ?>
      </div>
      <div ng-show="!secretaryChangeStatusBookBorrowerForm.$valid">
        <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;" disabled>Ubah Status</button>
      </div>
    </div>
  </form>
</div>
</body>