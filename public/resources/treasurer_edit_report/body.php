<body ng-app="treasurerManageReportsApp" ng-controller="treasurerManageReportsController">
  <div class="side-menu">
    <div class="profile-box-sekre">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Bendahara']['Folder_Bendahara'];?>/<?=$Variable['Data_Bendahara']['Foto_Bendahara'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Bendahara']['Nama'];?></span>
      <span>Sekretaris</span>
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
  <div class="form-buku" style="width:50%;margin:10px 0 50px 15%;display:block;position:relative">
    <span class="label-dash">Edit Laporan</span>
      <span><p style="margin-bottom:10px;margin-top: 15px;margin-left: 32px;width: 95%;">Isi salah satu dana masuk / dana keluar sesuai dengan laporan yang ingin dibuat. Tidak bisa mengosongkan kedua-duanya yaitu dana masuk dan dana keluar. Salah satu diantara form tersebut harus diisi. Input dana masuk / dana keluar hanya boleh berisi angka jika ingin input Rp 100.000 maka input seperti 100000.</p></span>
      <form method="POST" name="editReportForm">
         <div class="border-input">
            <input type="text" placeholder="Dana Masuk" type="text" name="income" data-ng-model="income" ng-pattern="/^[0-9]*$/">
        </div>
        <div ng-show="editReportForm.income.$error.pattern">
          <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
            Dana masuk hanya boleh berisi angka
          </font>
        </div>
        <div class="border-input">
            <input type="text" placeholder="Dana Keluar" type="text" name="spending" data-ng-model="spending" ng-pattern="/^[0-9]*$/">
        </div>
        <div ng-show="editReportForm.spending.$error.pattern">
          <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
            Dana keluar hanya boleh berisi angka
          </font>
        </div>
        <textarea style="margin: 10px 30px 0;width:295px;padding:8px;border-radius:5px;resize: none;" placeholder="Keterangan" name="information" data-ng-model="information" ng-minlength="10" ng-maxlength="1500" required></textarea>
            <div ng-show="editReportForm.information.$touched && editReportForm.information.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Keterangan masih kosong
            </font>
          </div>
          <div ng-show="editReportForm.information.$error.minlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Keterangan minimal terdapat 10 karakter
            </font>
          </div>
          <div ng-show="editReportForm.information.$error.maxlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Keterangan maksimal terdapat 1500 karakter
            </font>
          </div>
        <div ng-show="editReportForm.$valid">
          <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;" ng-click="treasurerEditReport()">Perbaharui</button>
        </div>
        <div ng-show="!editReportForm.$valid">
            <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;cursor: not-allowed;" disabled>Perbaharui</button>
        </div>
      </form>
    </div>
</body>