<body ng-app="secretaryManageCategoryApp" ng-controller="secretaryManageCategoryController">
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
      <li id="nav3" style="background:#1e202c;">
        <div class="menu-nav">
          <div class="icon-nav"><i class="fa fa-tags fa-1x"></i></div>
          <div class="ket-nav" ng-click="GotomanageCategoryPage()">Kelola Kategori</div>
        </div>
      </li>
      <li id="nav2">
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
    <span class="label-dash">Edit Kategori</span>
      <form method="POST" name="editCategoryForm">
  	     <div class="border-input">
            <input type="text" placeholder="Nama Kategori" name="categoryname" data-ng-model="categoryname" ng-minlength="3" ng-maxlength="40" ng-pattern="/^[a-zA-Z ]*$/" required>
        </div>
        <div ng-show="editCategoryForm.categoryname.$touched && editCategoryForm.categoryname.$error.required">
          <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
            Nama kategori masih kosong
          </font>
        </div>
        <div ng-show="editCategoryForm.categoryname.$error.minlength">
          <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
            Nama kategori minimal 3 karakter
          </font>
        </div>
        <div ng-show="editCategoryForm.categoryname.$error.maxlength">
          <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
            Nama kategori maksimal 40 karakter
          </font>
        </div>
        <div ng-show="editCategoryForm.categoryname.$error.pattern">
          <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
            Nama kategori hanya boleh berisi huruf dan spasi
          </font>
        </div>
        <div ng-show="editCategoryForm.$valid">
          <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;" ng-click="secretaryEditCategory()">Perbaharui</button>
        </div>
        <div ng-show="!editCategoryForm.$valid">
            <button type="submit" class="buttonSubmit" style="margin-top: 10px !important;cursor: not-allowed;" disabled>Perbaharui</button>
        </div>
      </form>
    </div>
</body>