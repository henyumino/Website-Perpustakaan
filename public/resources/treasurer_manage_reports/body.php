<body ng-app="treasurerManageReportsApp" ng-controller="treasurerManageReportsController">
  <h2>Manage Category</h2>
  <a href="<?=$Variable['URL'];?>treasurer/dashboard/" style="text-decoration: none;">Dashboard</a>
  <br/>
  <br/>
  <ng-form method="POST" name="addReportsForm">
    <center><h3>Form Tambahkan Laporan</h3></center>
    <div style="width:50%;text-align:left;margin-left:15px;padding:10px;">Isi salah satu dana masuk / dana keluar sesuai dengan laporan yang ingin dibuat. Tidak bisa
    mengosongkan kedua-duanya yaitu dana masuk dan dana keluar. Salah satu diantara form tersebut harus diisi. Input dana masuk / dana keluar hanya boleh berisi angka jika ingin input Rp 100.000 maka input seperti 100000.</div><br/>
 <table>
  <tr>
    <td>
      <label>Dana Masuk</label>
    </td>
    <td>
      <input type="text" name="income" ng-model="income" ng-pattern="/^[0-9]*$/"> 
    </td>
    <td>
      <div ng-show="addReportsForm.income.$error.pattern">
        <font style="color:red">Dana masuk hanya boleh berisi angka</font>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <label>Dana Keluar</label>
    </td>
    <td>
      <input type="text" name="spending" ng-model="spending" ng-pattern="/^[0-9]*$/"> 
    </td>
    <td>
      <div ng-show="addReportsForm.spending.$error.pattern">
        <font style="color:red">Dana keluar hanya boleh berisi angka</font>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <label>Keterangan</label>
    </td>
    <td>
      <textarea name="information" ng-model="information" ng-minlength="10" ng-maxlength="1500" required>
        
      </textarea> 
    </td>
    <td>
      <div ng-show="addReportsForm.information.$touched && addReportsForm.information.$error.required">
        <font style="color:red">Keterangan masih kosong</font>
      </div>
      <div ng-show="addReportsForm.information.$error.minlength">
        <font style="color:red">Keterangan minimal 10 karakter</font>
      </div>
      <div ng-show="addReportsForm.information.$error.maxlength">
        <font style="color:red">Keterangan maksimal 1500 karakter</font>
      </div>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <div ng-if="addReportsForm.$valid">
        <button type="submit" ng-click="treasurerAddReports()">Tambahkan</button>
      </div>
      <div ng-if="!addReportsForm.$valid">
        <button type="submit" disabled>Tambahkan</button>
      </div>
    </td>
  </tr>
 </table>
</ng-form>
 <br/>
 <h2>List Laporan</h2>
 <table align="center">
        <tr>
            <th style="padding:10px;margin:5px;">ID Laporan</th>
            <th style="padding:10px;margin:5px;">Waktu</th>
            <th style="padding:10px;margin:5px;">Dana Masuk</th>
            <th style="padding:10px;margin:5px;">Dana Keluar</th>
            <th style="padding:10px;margin:5px;">Keterangan</th>
            <th style="padding:10px;margin:5px;">Nama Bendahara</th>
            <th style="padding:10px;margin:5px;">Aksi</th>
        </tr>
   <?php

        if (empty($Variable['List_Laporan']) == false && empty($Variable['Hasil_Pencarian']))
        {

          for ($i=1; $i <= count($Variable['List_Laporan']); $i++) 
          {  
            ?>
              <tr>
                <td style="padding:10px;margin:5px;">
                  <?=$Variable['List_Laporan'][$i]['ID_Laporan'];?>
                </td>
                <td style="padding:10px;margin:5px;">
                  <?=$Variable['List_Laporan'][$i]['Waktu'];?>
                </td>
                <td style="padding:10px;margin:5px;">
                  <?=$Variable['List_Laporan'][$i]['Dana_Masuk'];?>
                </td>
                <td style="padding:10px;margin:5px;">
                  <?=$Variable['List_Laporan'][$i]['Dana_Keluar'];?>
                </td>
                <td style="padding:10px;margin:5px;">
                  <?=$Variable['List_Laporan'][$i]['Keterangan'];?>
                </td>
                <td style="padding:10px;margin:5px;">
                  <?=$Variable['List_Laporan'][$i]['Nama_Bendahara'];?>
                </td>
                <td style="padding:10px;margin:5px;">
                  <a href="<?=$Variable['URL'].'treasurer/manage_reports/edit.php?report_id='.$Variable['List_Laporan'][$i]['ID_Laporan'];?>">Edit</a> | <a href="<?=$Variable['URL'].'treasurer/manage_reports/delete.php?report_id='.$Variable['List_Laporan'][$i]['ID_Laporan'];?>">Hapus</a>
                </td>
              </tr>
            <?php
          }
        }
        else
        {
           ?> 
             <tr>
               <td style="padding:10px;margin:5px;"></td>
               <td style="padding:10px;margin:5px;"></td> 
               <td style="padding:10px;margin:5px;"></td>
               <td align="center" style="padding:10px;margin:5px;">Tidak laporan yang dapat ditampilkan</td>
               <td style="padding:10px;margin:5px;"></td>
               <td style="padding:10px;margin:5px;"></td>
               <td style="padding:10px;margin:5px;"></td>
             </tr>
          <?php
        }
    ?>
 </table>
     <center>
      <?php
              if ($Variable['Halaman_Paging'] < $Variable['Total_Halaman'])
              {
                ?> <a href="<?=$Variable['URL'].'treasurer/manage_reports/?page='.($Variable['Halaman_Paging']+1);?>">Selanjutnya</a> <?php
              }
              else
              {
                 echo " Selanjutnya ";
              }

              if ($Variable['Halaman_Paging'] > $Variable['Total_Halaman'] OR $Variable['Halaman_Paging'] == 1)
              {
                 echo " Sebelumnya ";
              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'treasurer/manage_reports/?page='.($Variable['Halaman_Paging']-1);?>">Sebelumnya</a> <?php
              } 
      ?>
    </center>
<h2>Cari Laporan</h2>
 <ng-form method="POST" name="searchReportsForm">
  <table>
    <tr>
      <td></td>
      <td>
        Cari laporan berdasarkan bulan dan tahun
      </td>
    </tr>
    <tr>
      <td>
        <label>Bulan</label>
      </td>
      <td>
        <select name="month" ng-model="month" required>
          <option value="" selected></option>
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
      </td>
      <td>      
        <div ng-show="searchReportsForm.month.$touched && searchReportsForm.month.$error.required">
          <font style="color:red">Bulan masih kosong</font>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <label>Tahun</label>
      </td>
      <td>
        <select name="year" data-ng-model="year" required>
          <option value="" selected></option>
          <?php 
              for ($i=1990; $i<= date("Y"); $i++) 
              { 
              
              ?>  <option value="<?=$i;?>"><?=$i;?></option>
              <?php
              
              }
              
              ?>
        </select>
      </td>
      <td>
        <div ng-show="searchReportsForm.year.$touched && searchReportsForm.year.$error.required">
          <font style="color:red">Tahun masih kosong</font>
        </div>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <div ng-if="searchReportsForm.$valid">
          <button type="submit" ng-click="searchReport()">Cari</button>
        </div>
        <div ng-if="!searchReportsForm.$valid">
          <button type="submit" disabled>Cari</button>
        </div>
      </td>
    </tr> 
  </table>
 </ng-form>
 <div ng-model="showResult" ng-show="showResult == true">
   <div ng-model="showTableResult" ng-show="showTableResult == true">
    <table align="center">
        <tr>
            <th style="padding:10px;margin:5px;">ID Laporan</th>
            <th style="padding:10px;margin:5px;">Waktu</th>
            <th style="padding:10px;margin:5px;">Dana Masuk</th>
            <th style="padding:10px;margin:5px;">Dana Keluar</th>
            <th style="padding:10px;margin:5px;">Keterangan</th>
            <th style="padding:10px;margin:5px;">Nama Bendahara</th>
            <th style="padding:10px;margin:5px;">Aksi</th>
        </tr>
        <tr ng-repeat="data in resultSearch">
            <td style="padding:10px;margin:5px;">{{data.ID_Laporan}}</td>
            <td style="padding:10px;margin:5px;">{{data.Waktu}}</td>
            <td style="padding:10px;margin:5px;">{{data.Dana_Masuk}}</td>
            <td style="padding:10px;margin:5px;">{{data.Dana_Keluar}}</td>
            <td style="padding:10px;margin:5px;">{{data.Keterangan}}</td>
            <td style="padding:10px;margin:5px;">{{data.Nama_Bendahara}}</td>
            <td style="padding:10px;margin:5px;"><a ng-href="http://localhost:8080/projekuas/treasurer/manage_reports/edit.php?report_id={{data.ID_Laporan}}">Edit</a> | <a ng-href="http://localhost:8080/projekuas/treasurer/manage_reports/delete.php?report_id={{data.ID_Laporan}}">Hapus</a></td>
        </tr>
    </table>
   </div>
   <div ng-model="showTextResult" ng-show="showTextResult == true">
     <div ng-model="no_result" align="center">
       {{no_result}}
     </div>
   </div>
 </div>
</ng-form>
</body>