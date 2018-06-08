<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="treasurerDashboardApp" ng-controller="treasurerDashboardController">
	<div class="side-menu">
    <div class="profile-box-sekre">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Bendahara']['Folder_Bendahara'];?>/<?=$Variable['Data_Bendahara']['Foto_Bendahara'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Bendahara']['Nama'];?></span>
      <span>Bendahara</span>
    </div>
    <div class="cat">MAIN</div>
    <ul>
      <li id="nav1" style="background:#1e202c;">
        <div class="menu-nav">
          <div class="icon-nav" style="margin-top: -4px;"><img src="<?=$Variable['URL'];?>resources/assets/icon/add_plus.png"/></div>
          <div class="ket-nav" ng-click="GotomanageReportPage()">Kelola Laporan</div>
        </div>
      </li>
    </ul>
  </div>
  <div class="menu-atas">
    <i class="fa fa-bars fa-2x" id="toggle-button"></i>
    <span>Halaman Bendahara</span>
    <div class="setting">
      <button type="button" name="button" ng-click="GotoAccountSettings()"><i class="fa fa-cog fa-1x"></i><span>Pengaturan<span></button>
      <button type="button" name="button" ng-click="GotoLogout()"><i class="fa fa-sign-out fa-1x"></i><span>Keluar<span></button>
    </div>
  </div>
  <div class="main-dash" id="kelola-buku">
    <span class="label-dash">Kelola Laporan</span>
    <span class="ket-dash">Dashboard / Kelola Laporan</span>
    <div class="tambah-buku">
      <img src="<?=$Variable['URL'];?>resources/assets/icon/add.png">
    </div>
    <ng-form method="POST" name="searchReportsForm"> 
	   <div class="main-tab" style="background-color: transparent !important;border: none !important;">
        <select name="month" ng-model="month" required id="change-status" style="display: inline-block;">
          <option value="" selected>Bulan</option>
          <option value="01">Januari</option>
          <option value="02">Februari</option>
          <option value="03">Maret</option>
          <option value="04">April</option>
          <option value="05">Mei</option>
          <option value="06">Juni</option>
          <option value="07">Juli</option>
          <option value="08">Agustus</option>
          <option value="09">September</option>
          <option value="10">Oktober</option>
          <option value="11">November</option>
          <option value="12">Desember</option>
        </select>
        <div ng-if="searchReportsForm.month.$error.required" style="display: inline-block !important;">
          <select name="year" data-ng-model="$parent.year" required id="change-status" disabled style="cursor: not-allowed;">
          <option value="" selected>Tahun</option>
          <?php 
              for ($i=1990; $i<= date("Y"); $i++) 
              { 
              
              ?>  <option value="<?=$i;?>"><?=$i;?></option>
              <?php
              
              }
              
              ?>
        </select>
        </div>
        <div ng-if="!searchReportsForm.month.$error.required" style="display: inline-block !important;">        
        <select name="year" data-ng-model="$parent.year" required id="change-status">
          <option value="" selected>Tahun</option>
          <?php 
              for ($i=1990; $i<= date("Y"); $i++) 
              { 
              
              ?>  <option value="<?=$i;?>"><?=$i;?></option>
              <?php
              
              }
              
              ?>
        </select>
        </div>
        <div ng-if="searchReportsForm.$valid">
          <button type="submit" ng-click="searchReport()" style="margin-right: 360px;margin-top: -30px;height: 30px;width: 200px;">Cari Laporan</button>
        </div>
        <div ng-if="!searchReportsForm.$valid">
          <button type="submit" style="margin-right: 360px;margin-top: -30px;height: 30px;width: 200px;cursor: not-allowed;">Cari Laporan</button>
        </div>
       </div>
    	<div ng-show="searchReportsForm.month.$touched && searchReportsForm.month.$error.required">
 			<font style="color:red;display:table;color:red;width:20%;top:5px;bottom:5px;left:25px;margin-bottom: 15px;margin-left:15px;position:relative;float: left;">
 			    Bulan masih kosong
 		    </font>
 		</div>
    <div ng-show="searchReportsForm.year.$touched && searchReportsForm.year.$error.required">
      <font style="color:red;display:table;color:red;width:20%;top:5px;bottom:5px;left:275px;position:relative;margin-left: 15px;margin-bottom: 30px;">
          Tahun masih kosong
        </font>
    </div>
    </ng-form>
    <hr class="garis-dash">
    <div class="list-buku">
    <?php 
    	if (empty($Variable['List_Laporan']) == false)
        {
        	?>

        	<table>
     	  	   <tr>
	            <td>Waktu</td>
    	        <td>Dana Masuk</td>
        	    <td>Dana Keluar</td>
            	<td>Keterangan</td>
            	<td>Nama Bendahara</td>
            	<td>Aksi</td>
          	  </tr>
       <?php
        	for ($i=1; $i <= count($Variable['List_Laporan']); $i++) 
            {
    ?>		 <tr>
                <td>
                  <?=$Variable['List_Laporan'][$i]['Waktu'];?>
                </td>
                <td>
                  <?=$Variable['List_Laporan'][$i]['Dana_Masuk'];?>
                </td>
                <td>
                  <?=$Variable['List_Laporan'][$i]['Dana_Keluar'];?>
                </td>
                <td>
                  <?=$Variable['List_Laporan'][$i]['Keterangan'];?>
                </td>
                <td>
                  <?=$Variable['List_Laporan'][$i]['Nama_Bendahara'];?>
                </td>
          		<td>
                  <a style="color: blue;" href="javascript:void(0)" ng-click="GotoTreasureredtReport('<?=$Variable['List_Laporan'][$i]['ID_Laporan'];?>')">Edit</a> | <a style="color: blue;" href="javascript:void(0)" ng-click="GotoTreasurerdelReport('<?=$Variable['List_Laporan'][$i]['ID_Laporan'];?>')">Hapus</a>
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
      	  <div class="not-table" style="width: 80% !important;margin: 100px 0px 0px 400px !important;">
        	<span>Tidak ada laporan yang dapat ditampilkan</span>
      	  </div>
    <?php
    	}
    ?>
    <div class="pagging">
    <?php
              if ($Variable['Halaman_Paging'] < $Variable['Total_Halaman'])
              {
                ?> <a href="<?=$Variable['URL'].'treasurer/dashboard/index.php?page='.($Variable['Halaman_Paging']+1);?>" style="color: blue;">Selanjutnya</a> <?php
              }
              else
              {

              }

              if ($Variable['Halaman_Paging'] > $Variable['Total_Halaman'] OR $Variable['Halaman_Paging'] == 1)
              {

              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'treasurer/dashboard/index.php?page='.($Variable['Halaman_Paging']-1);?>" style="color: blue;">Sebelumnya</a> <?php
              } 
      ?>
      </div>
      <div ng-model="showResult" ng-show="showResult == true">
    <div ng-model="showTableResult" ng-show="showTableResult == true">
     <hr class="garis-dash">
      <div ng-model="getKeyword"><p style="margin-top: 15px;margin-left: 32px;width: 95%;"><p style="margin-top: 15px;margin-left: 32px;width: 95%;">{{getResultInfo}}</p></div>
      <div class="list-buku">
        <table>
             <tr>
            <td>Waktu</td>
            <td>Dana Masuk</td>
            <td>Dana Keluar</td>
            <td>Keterangan</td>
            <td>Nama Bendahara</td>
            <td>Aksi</td>
        </tr>
        <tr ng-repeat="data in resultSearch">
            <td>{{data.Waktu}}</td>
            <td>{{data.Dana_Masuk}}</td>
            <td>{{data.Dana_Keluar}}</td>
            <td>{{data.Keterangan}}</td>
            <td>{{data.Nama_Bendahara}}</td>
            <td><a style="color: blue;" ng-href="javascript:void(0)" ng-click="GotoTreasurerEditReport(data)">Edit</a> | <a style="color: blue;" ng-href="javascript:void(0)" ng-click="GotoTreasurerDeleteReport(data)">Hapus</a></td>
        </tr>
            </table>
      </div>
    </div>
  </div>
  <div ng-model="showTextResult" ng-show="showTextResult == true">
   <hr class="garis-dash">
     <div ng-model="no_result">
       <p style="margin-top: 15px;margin-left: 32px;width: 95%;">{{no_result}}</p>
     </div>
    </div>
  </div>
</div>
   <div class="main-dash" id="statistik">
    statistik
  </div>
  <div class="main-dash" id="tambah-buku">
    <span class="label-dash">Tambah Laporan</span>
    <span class="ket-dash">Dashboard / Kelola Laporan / Tambah Laporan</span>
    <hr class="garis-dash">
    <div class="form-buku">
      <span class="label-dash">Tambah Laporan</span>
       <ng-form method="POST" name="addReportsForm">
         <span><p style="margin-bottom:10px;margin-top: 15px;margin-left: 32px;width: 95%;">Isi salah satu dana masuk / dana keluar sesuai dengan laporan yang ingin dibuat. Tidak bisa mengosongkan kedua-duanya yaitu dana masuk dan dana keluar. Salah satu diantara form tersebut harus diisi. Input dana masuk / dana keluar hanya boleh berisi angka jika ingin input Rp 100.000 maka input seperti 100000.</p></span>
            <div class="border-input">
              <input type="text" placeholder="Dana Masuk" name="income" ng-model="income" ng-pattern="/^[0-9]*$/">
            </div>
          <div ng-show="addReportsForm.income.$error.pattern">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Dana masuk hanya boleh berisi angka
            </font>
          </div>
          <div class="border-input">
              <input type="text" placeholder="Dana Keluar" name="spending" ng-model="spending" ng-pattern="/^[0-9]*$/">
            </div>
          <div ng-show="addReportsForm.spending.$error.pattern">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Dana keluar hanya boleh berisi angka
            </font>
          </div>
          <textarea style="margin: 10px 30px 0;width:295px;padding:8px;border-radius:5px;resize: none;" placeholder="Keterangan" name="information" ng-model="information" ng-minlength="10" ng-maxlength="1500" required></textarea>
            <div ng-show="addReportsForm.information.$touched && addReportsForm.information.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Keterangan masih kosong
            </font>
          </div>
          <div ng-show="addReportsForm.information.$error.minlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Keterangan minimal terdapat 10 karakter
            </font>
          </div>
          <div ng-show="addReportsForm.information.$error.maxlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Keterangan maksimal terdapat 1500 karakter
            </font>
          </div>
          <div ng-show="addReportsForm.$valid">
                    <button type="submit" class="buttonSubmit" ng-click="treasurerAddReports()" style="margin-top: 20px;">Tambah Laporan</button>
                </div>
                <div ng-show="!addReportsForm.$valid">
                    <button type="submit" class="buttonSubmit" style="cursor: not-allowed;margin-top: 20px;" disabled>Tambah Laporan</button>
                </div>
       </ng-form>
     </div>
    </div>
 </div>
</body>