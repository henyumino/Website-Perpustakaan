<body ng-app="secretaryManageBooksApp" ng-controller="secretaryManageBooksController">
 <div class="side-menu">
    <div class="profile-box-sekre">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Sekretaris']['Folder_Sekretaris'];?>/<?=$Variable['Data_Sekretaris']['Foto_Sekretaris'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Sekretaris']['Nama'];?></span>
      <span>Sekretaris</span>
    </div>
    <div class="cat">MAIN</div>
    <ul>
      <li id="nav1">
        <div class="menu-nav">
          <div class="icon-nav"><img src="<?=$Variable['URL'];?>resources/assets/icon/kelola-buku.png"/></div>
          <div class="ket-nav" ng-click="GotomanageBookPage()">Kelola Buku</div>
        </div>
      </li>
      <li id="nav3">
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
    <span class="label-dash">Edit Buku</span>
      <form method="POST" name="editBookForm">
           <div class="border-input">
              <input type="text" placeholder="Judul Buku" name="booktitle" data-ng-model="booktitle" ng-minlength="5" ng-maxlength="80" required>
            </div>
            <div ng-show="editBookForm.booktitle.$touched && editBookForm.booktitle.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Judul masih kosong
            </font>
          </div>
          <div ng-show="editBookForm.booktitle.$error.minlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Judul buku minimal 5 karakter
            </font>
          </div>
          <div ng-show="editBookForm.booktitle.$error.maxlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Judul buku maksimal 80 karakter
            </font>
          </div>
          <textarea style="margin: 10px 30px 0;width:295px;height: 150px;padding:8px;border-radius:5px;resize: none;" placeholder="Deskripsi Buku" name="bookdescription" data-ng-model="bookdescription" ng-minlength="50" ng-maxlength="1000" required></textarea>
            <div ng-show="editBookForm.bookdescription.$touched && editBookForm.bookdescription.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Deskripsi buku masih kosong
            </font>
          </div>
          <div ng-show="editBookForm.bookdescription.$error.minlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Deskripsi buku minimal 50 karakter
            </font>
          </div>
          <div ng-show="editBookForm.bookdescription.$error.maxlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Deskripsi buku maksimal 1000 karakter
            </font>
          </div>   
          <div class="border-input">
              <input type="text" placeholder="Nama Pengarang" name="authorname" ng-model="authorname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>
            </div>
            <div ng-show="editBookForm.authorname.$touched && editBookForm.authorname.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Nama pengarang masih kosong
            </font>
          </div>
          <div ng-show="editBookForm.authorname.$error.minlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Nama pengarang minimal 3 karakter
            </font>
          </div>
          <div ng-show="editBookForm.authorname.$error.maxlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Nama pengarang maksimal 25 karakter
            </font>
          </div>
          <div ng-show="editBookForm.authorname.$error.pattern">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Nama pengarang hanya boleh berisi huruf dan spasi
            </font>
          </div>
          <div class="border-input">
              <input type="text" placeholder="Penerbit Buku" type="text" name="bookpublisher" data-ng-model="bookpublisher" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="5" ng-maxlength="50" required>
            </div>
            <div ng-show="editBookForm.bookpublisher.$touched && editBookForm.bookpublisher.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Penerbit buku masih kosong
            </font>
          </div>
          <div ng-show="editBookForm.bookpublisher.$error.minlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Penerbit buku minimal 5 karakter
            </font>
          </div>
          <div ng-show="editBookForm.bookpublisher.$error.maxlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Penerbit buku maksimal 50 karakter
            </font>
          </div>
          <div ng-show="editBookForm.bookpublisher.$error.pattern">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Penerbit buku hanya boleh berisi huruf dan spasi
            </font>
          </div>    
          <select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="datepublished" data-ng-model="datepublished" required>
            <option value="" disabled>Tanggal Terbit</option>
            <?php 
                  for ($i=1; $i<= 31; $i++) 
                  { 
                    ?> <option value="<?=$i;?>"><?=$i;?></option>
            <?php
                  }
            ?>
          </select>
          <div ng-show="editBookForm.datepublished.$touched && editBookForm.datepublished.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Tanggal terbit masih kosong
            </font>
          </div>  
          <select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="monthpublished" data-ng-model="monthpublished" required>
              <option value="" disabled>Bulan Terbit</option>
              <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
          </select>
          <div ng-show="editBookForm.monthpublished.$touched && editBookForm.monthpublished.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Bulan terbit masih kosong
            </font>
          </div>  
          <select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="yearpublished" ng-model="yearpublished" required>
            <option value="" disabled>Tahun Terbit</option>
              <?php 
                        for ($i=1990; $i<= date("Y"); $i++) 
                        { 
                  ?>      <option value="<?=$i;?>"><?=$i;?></option>
                  <?php
                        }
                  ?>
            </select>
            <div ng-show="editBookForm.yearpublished.$touched && editBookForm.yearpublished.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Tahun terbit masih kosong
            </font>
          </div>
          <div class="border-input">
              <input type="text" placeholder="Tempat Terbit" name="placepublished" data-ng-model="placepublished" ng-pattern="/^[a-zA-Z-0-9 ]*$/" ng-minlength="5" ng-maxlength="50" required> 
            </div>
            <div ng-show="editBookForm.placepublished.$touched && editBookForm.placepublished.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Tempat terbit masih kosong
            </font>
          </div>
          <div ng-show="editBookForm.placepublished.$error.minlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Tempat terbit minimal 5 karakter
            </font>
          </div>
          <div ng-show="editBookForm.placepublished.$error.maxlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Tempat terbit maksimal 50 karakter
            </font>
          </div>
          <div ng-show="editBookForm.placepublished.$error.pattern">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Tempat terbit hanya boleh berisi huruf, angka dan spasi
            </font>
          </div>
          <select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="bookcategory" data-ng-model="bookcategory" required>
              <option value="" disabled>Kategori Buku</option>
              <?php
                    for ($i=1; $i <= count($Variable['Kategori_Buku']); $i++) 
                    { 
                      ?> <option value="<?=$Variable['Kategori_Buku'][$i];?>"><?=$Variable['Kategori_Buku'][$i];?></option> <?php
                    }
              ?>
          </select>
          <div ng-show="editBookForm.bookcategory.$touched && editBookForm.bookcategory.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Kategori buku masih kosong
            </font>
          </div>
          <div class="border-input">
              <input type="text" placeholder="Jumlah Buku" name="numberofbook" data-ng-model="numberofbook" ng-pattern="/^[0-9]*$/" ng-minlength="1" ng-maxlength="5000" required> 
            </div>
            <div ng-show="editBookForm.numberofbook.$touched && editBookForm.numberofbook.$error.required">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Jumlah buku masih kosong
            </font>
          </div>
          <div ng-show="editBookForm.numberofbook.$error.minlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Jumlah buku minimal terdapat 1 buku
            </font>
          </div>
          <div ng-show="editBookForm.numberofbook.$error.maxlength">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Jumlah buku maksimal terdapat 5000 buku
            </font>
          </div>
          <div ng-show="editBookForm.numberofbook.$error.pattern">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Jumlah buku hanya boleh berisi angka
            </font>
          </div>
          <div ng-show="numberofbook <= 0">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Jumlah buku minimal adalah 1
            </font>
          </div>
          <div ng-show="numberofbook > 5000">
            <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
              Jumlah buku maksimal adalah 5000
            </font>
          </div>    
          <div class="crop-area">
            <div ngf-drop ng-model="bookimg" ngf-pattern="image/*" class="cropArea">
              <img-crop image="bookimg  | ngfDataUrl" result-image="croppedBookImg" ng-init="croppedBookImg=''">
              </img-crop>
            </div>
          </div>
          <div ng-show="!bookimg">
            <img src="<?=$Variable['URL'].'resources/assets/'.$Variable['Data']['Folder_Buku'].'/'.$Variable['Data']['Foto_Buku'];?>">
          </div>
          <div ng-show="bookimg">
            <div class="crop-area-res">
              <img ng-src="{{croppedBookImg}}"/>
            </div>
          </div>
          <button class="buttonUpload" ngf-select ng-model="bookimg" accept="image/*"> 
            <label for="file"><i class="fa fa-upload fa-1x"></i> Ganti Gambar</label>
          </button>
          <br>    
          <div ng-show="editBookForm.$valid">
            <button type="submit" class="buttonSubmit" ng-click="secretaryEditBook(croppedBookImg, bookimg.name)">Perbaharui</button>
          </div>
          <div ng-show="!editBookForm.$valid">
            <button type="submit" class="buttonSubmit" style="cursor: not-allowed;" disabled>Perbaharui</button>
          </div>
        </form>
      </div>
</body>