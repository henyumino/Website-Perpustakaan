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
  <div class="main-dash">
    <span class="label-dash">Kelola Kategori</span>
    <span class="ket-dash">Dashboard / Kelola Kategori</span>
  <hr class="garis-dash">
  <ng-form method="POST" name="searchCategoryForm">
    <div class="main-tab" style="margin-bottom: 30px !important;">
      <div class="search-cat">
        <i class="fa fa-search fa-2x" ng-click="searchCategoryForm.$valid ? searchCategory() : errorSearchCategory()"></i>
        <input placeholder="Cari Buku Berdasarkan Nama" type="text" name="keyword" ng-model="keyword" required>
      </div>
      <button type="button" name="button" id="button-cat">Tambah Kategori Baru</button>
    </div>
  </ng-form>
    <div class="main-tab-1" id="add-cat" style="margin-top: -30px !important;height: auto !important;">
      <ng-form method="POST" name="addCategoryForm">
        <i class="fa fa-close fa-2x" id="close-cat" style="padding-top: 115px;padding-right: 5px;"></i>
        <span style="margin-left:30px;">Nama Kategori</span>
          <input type="text" name="categoryname" ng-model="categoryname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="5" ng-maxlength="40" required>
          <div ng-show="addCategoryForm.categoryname.$touched && addCategoryForm.categoryname.$error.required">
             <font style="color:red;display:inline-block;color:red;width:30%;top:5px;bottom:5px;left:135px;margin:10px;position:relative;">
                Nama kategori masih kosong
             </font>
          </div>
          <div ng-show="addCategoryForm.categoryname.$error.minlength">
             <font style="color:red;display:inline-block;color:red;width:30%;top:5px;bottom:5px;left:135px;margin:10px;position:relative;">
                Nama kategori minimal 3 karakter
             </font>
          </div>
          <div ng-show="addCategoryForm.categoryname.$error.maxlength">
             <font style="color:red;display:inline-block;color:red;width:30%;top:5px;bottom:5px;left:135px;margin:10px;position:relative;">
                Nama kategori maksimal 40 karakter
             </font>
          </div>
          <div ng-show="addCategoryForm.categoryname.$error.pattern">
             <font style="color:red;display:inline-block;color:red;width:30%;top:5px;bottom:5px;left:135px;margin:10px;position:relative;">
                Nama kategori hanya boleh berisi huruf dan spasi
             </font>
          </div>
          <div ng-if="addCategoryForm.$valid">
            <button type="button" name="button" style="margin-left: 143px !important;margin-bottom: 20px !important;" ng-click="secretaryAddCategory()">Tambahkan</button>
          </div>
          <div ng-if="!addCategoryForm.$valid">
            <button type="button" name="button" style="margin-left: 143px !important;margin-bottom: 20px !important;cursor: not-allowed;" disabled>Tambahkan</button>
          </div>
      </ng-form>
    </div>
    <div class="list-buku">
    <?php 
      if (empty($Variable['Kategori_Buku']) == false)
        {
          ?>
      <table>
        <tr>
          <td>Nama</td>
          <td>Ditambahkan</td>
          <td>Nama Sekretaris</td>
          <td>Aksi</td>
        </tr>
        <?php
          for ($i=1; $i <= count($Variable['Kategori_Buku']); $i++) 
            {
    ?>     <tr>
              <td><?=$Variable['Kategori_Buku'][$i]['Nama'];?></td>
              <td><?=$Variable['Kategori_Buku'][$i]['Ditambahkan'];?></td>
              <td><?=$Variable['Kategori_Buku'][$i]['Nama_Sekretaris'];?></td>
              <td><a href="javascript:void(0)" ng-click="GotoSecretaryedtCategory('<?=$Variable['Kategori_Buku'][$i]['ID_Kategori_Buku'];?>')" style="color:blue;">Edit</a> | <a href="javascript:void(0)" ng-click="secretarydelCategory('<?=$Variable['Kategori_Buku'][$i]['ID_Kategori_Buku'];?>')" style="color:blue;">Hapus</a></td>
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
      <div class="pagging">
    <?php
              if ($Variable['Halaman_Paging'] < $Variable['Total_Halaman'])
              {
                ?> <a href="<?=$Variable['URL'].'secretary/manage_category/index.php?page='.($Variable['Halaman_Paging']+1);?>" style="color: blue;">Selanjutnya</a> <?php
              }
              else
              {

              }

              if ($Variable['Halaman_Paging'] > $Variable['Total_Halaman'] OR $Variable['Halaman_Paging'] == 1)
              {

              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'secretary/manage_category/index.php?page='.($Variable['Halaman_Paging']-1);?>" style="color: blue;">Sebelumnya</a> <?php
              } 
      ?>
      </div>
  </div>
  <div ng-model="showResult" ng-show="showResult == true">
    <div ng-model="showTableResult" ng-show="showTableResult == true">
     <hr class="garis-dash">
      <div ng-model="getKeyword"><p style="margin-top: 15px;margin-left: 32px;width: 95%;">Hasil pencarian <strong>{{getKeyword}}</strong></p></div>
      <div class="list-buku">
        <table>
             <tr>
                <td>Nama</td>
                <td>Ditambahkan</td>
                <td>Nama Sekretaris</td>
                <td>Aksi</td>
              </tr>
              <tr ng-repeat="data in resultSearch">
                <td>{{data.Nama}}</td>
                <td>{{data.Ditambahkan}}</td>
                <td>{{data.Nama_Sekretaris}}</td>
                <td><a ng-href="javascript:void(0)" ng-click="GotoSecretaryEditCategory(data)" style="color: blue;">Edit</a> | <a ng-href="javascript:void(0)" ng-click="secretaryDeleteCategory(data)" style="color: blue;">Hapus</a></td>
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
</div>
</span>
</body>