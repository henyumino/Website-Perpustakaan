<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="secretaryDashboardApp" ng-controller="secretaryDashboardController">
	<div class="side-menu">
    <div class="profile-box-sekre">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Sekretaris']['Folder_Sekretaris'];?>/<?=$Variable['Data_Sekretaris']['Foto_Sekretaris'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Sekretaris']['Nama'];?></span>
      <span>Sekretaris</span>
    </div>
    <div class="cat">MAIN</div>
    <ul>
      <li id="nav1" style="background:#1e202c;">
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
  <div class="main-dash" id="kelola-buku">
    <span class="label-dash">Kelola Buku</span>
    <span class="ket-dash">Dashboard / Kelola Buku</span>
    <div class="tambah-buku">
      <img src="<?=$Variable['URL'];?>resources/assets/icon/book-black.png" alt="">
    </div>
    <ng-form method="POST" name="searchBookForm"> 
	   <div class="main-tab">
    	  <div class="search-cat">
    	  	<i class="fa fa-search fa-2x" ng-click="searchBookForm.$valid ? searchBook() : errorSearchBook()"></i>
            <input placeholder="Cari Buku Berdasarkan Judul" type="text" name="keyword" ng-model="keyword" required>
		  </div>
       </div>
    	<div ng-show="searchBookForm.keyword.$touched && searchBookForm.keyword.$error.required">
 			<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			    Kata kunci masih kosong
 		    </font>
 		</div>
    </ng-form>
    <hr class="garis-dash">
    <div class="list-buku">
    <?php 
    	if (empty($Variable['Data_Buku']) == false)
        {
        	?>

        	<table>
     	  	   <tr>
          		<td>Judul Buku</td>
          		<td>Nama Pengarang</td>
          		<td>Penerbit Buku</td>
          		<td>Kategori Buku</td>
          		<td>Nama Sekretaris</td>
          		<td>Aksi</td>
          	  </tr>
       <?php
        	for ($i=1; $i <= count($Variable['Data_Buku']); $i++) 
            {
    ?>		 <tr>
          		<td><?=$Variable['Data_Buku'][$i]['Judul_Buku'];?></td>
        	    <td><?=$Variable['Data_Buku'][$i]['Pengarang_Buku'];?></td>
          		<td><?=$Variable['Data_Buku'][$i]['Penerbit_Buku'];?></td>
          		<td><?=$Variable['Data_Buku'][$i]['Kategori_Buku'];?></td>
         		<td><?=$Variable['Data_Buku'][$i]['Nama_Sekretaris'];?></td>
          		<td><a href="javascript:void(0)" ng-click="GotoSecretaryedtBook('<?=$Variable['Data_Buku'][$i]['ID_Buku'];?>')" style="color:blue;">Edit</a> | <a href="javascript:void(0)" ng-click="secretarydelBook('<?=$Variable['Data_Buku'][$i]['ID_Buku'];?>')" style="color:blue;">Hapus</a></td>
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
                ?> <a href="<?=$Variable['URL'].'secretary/dashboard/index.php?page='.($Variable['Halaman_Paging']+1);?>" style="color: blue;">Selanjutnya</a> <?php
              }
              else
              {

              }

              if ($Variable['Halaman_Paging'] > $Variable['Total_Halaman'] OR $Variable['Halaman_Paging'] == 1)
              {

              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'secretary/dashboard/index.php?page='.($Variable['Halaman_Paging']-1);?>" style="color: blue;">Sebelumnya</a> <?php
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
          		<td>Judul Buku</td>
          		<td>Nama Pengarang</td>
          		<td>Penerbit Buku</td>
          		<td>Kategori Buku</td>
          		<td>Nama Sekretaris</td>
          		<td>Aksi</td>
          	  </tr>
          	  <tr ng-repeat="data in resultSearch">
          	  	<td>{{data.Judul_Buku}}</td>
            	<td>{{data.Nama_Pengarang}}</td>
            	<td>{{data.Penerbit_Buku}}</td>
           		<td>{{data.Kategori_Buku}}</td>
           		<td>{{data.Nama_Sekretaris}}</td>
           		<td><a ng-href="javascript:void(0)" ng-click="GotoSecretaryEditBook(data)" style="color: blue;">Edit</a> | <a ng-href="javascript:void(0)" ng-click="secretaryDeleteBook(data)" style="color: blue;">Hapus</a></td>
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
  <div class="main-dash" id="statistik">
    statistik
  </div>
  <div class="main-dash" id="tambah-buku">
    <span class="label-dash">Tambah Buku</span>
    <span class="ket-dash">Dashboard / Kelola Buku / Tambah Buku</span>
    <hr class="garis-dash">
    <div class="form-buku">
      <span class="label-dash">Tambah Buku</span>
       <ng-form method="POST" name="addBookForm">
       	<?php
        	  if (empty($Variable['Kategori_Buku']))
        	  {
          ?>
           	 <span><p style="margin-top: 15px;margin-left: 32px;width: 95%;">Anda belum menambahkan kategori buku jika anda ignin menambahkan buku anda harus menambahkan kategori buku terlebih dahulu.</p></span>
         	 <br/>
          <?php
              }
              else
              {
          ?>
 		     	<div class="border-input">
      				<input type="text" placeholder="Judul Buku" name="booktitle" ng-model="booktitle" ng-minlength="5" ng-maxlength="80" required>
      			</div>
      			<div ng-show="addBookForm.booktitle.$touched && addBookForm.booktitle.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Judul masih kosong
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.booktitle.$error.minlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Judul buku minimal 5 karakter
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.booktitle.$error.maxlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Judul buku maksimal 80 karakter
 			     	</font>
 			    </div>
      			<textarea style="margin: 10px 30px 0;width:295px;padding:8px;border-radius:5px;resize: none;" placeholder="Deskripsi Buku" name="bookdescription" ng-model="bookdescription" ng-minlength="50" ng-maxlength="1000" required></textarea>
      			<div ng-show="addBookForm.bookdescription.$touched && addBookForm.bookdescription.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Deskripsi buku masih kosong
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.bookdescription.$error.minlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Deskripsi buku minimal 50 karakter
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.bookdescription.$error.maxlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Deskripsi buku maksimal 1000 karakter
 			     	</font>
 			    </div>
 		     	<div class="border-input">
      				<input type="text" placeholder="Nama Pengarang" name="authorname" ng-model="authorname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>
		      	</div>
		      	<div ng-show="addBookForm.authorname.$touched && addBookForm.authorname.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Nama pengarang masih kosong
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.authorname.$error.minlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Nama pengarang minimal 3 karakter
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.authorname.$error.maxlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Nama pengarang maksimal 25 karakter
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.authorname.$error.pattern">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Nama pengarang hanya boleh berisi huruf dan spasi
 			     	</font>
 			    </div>
		      	<div class="border-input">
      				<input type="text" placeholder="Penerbit Buku" type="text" name="bookpublisher" ng-model="bookpublisher" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="5" ng-maxlength="50" required>
		      	</div>
		      	<div ng-show="addBookForm.bookpublisher.$touched && addBookForm.bookpublisher.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Penerbit buku masih kosong
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.bookpublisher.$error.minlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Penerbit buku minimal 5 karakter
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.bookpublisher.$error.maxlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Penerbit buku maksimal 50 karakter
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.bookpublisher.$error.pattern">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Penerbit buku hanya boleh berisi huruf dan spasi
 			     	</font>
 			    </div>
  		    	<select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="datepublished" ng-model="datepublished" required>
  		    		<option value="" disabled selected>Tanggal Terbit</option>
      				<?php 
                          for ($i=1; $i<= 31; $i++) 
                          { 
                            ?> <option value="<?=$i;?>"><?=$i;?></option>
                    <?php
                          }
                    ?>
      			</select>
      			<div ng-show="addBookForm.datepublished.$touched && addBookForm.datepublished.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Tanggal terbit masih kosong
 			     	</font>
 			    </div>
 			    <select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="monthpublished" ng-model="monthpublished" required>
  		    		<option value="" disabled selected>Bulan Terbit</option>
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
      			<div ng-show="addBookForm.monthpublished.$touched && addBookForm.monthpublished.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Bulan terbit masih kosong
 			     	</font>
 			    </div>
 			    <select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="yearpublished" ng-model="yearpublished" required>
  		    		<option value="" disabled selected>Tahun Terbit</option>
      				<?php 
                        for ($i=1990; $i<= date("Y"); $i++) 
                        { 
                  ?>      <option value="<?=$i;?>"><?=$i;?></option>
                  <?php
                        }
                  ?>
      			</select>
      			<div ng-show="addBookForm.yearpublished.$touched && addBookForm.yearpublished.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Tahun terbit masih kosong
 			     	</font>
 			    </div>
		      	<div class="border-input">
      				<input type="text" placeholder="Tempat Terbit" name="placepublished" ng-model="placepublished" ng-pattern="/^[a-zA-Z-0-9 ]*$/" ng-minlength="5" ng-maxlength="50" required> 
      			</div>
      			<div ng-show="addBookForm.placepublished.$touched && addBookForm.placepublished.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Tempat terbit masih kosong
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.placepublished.$error.minlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Tempat terbit minimal 5 karakter
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.placepublished.$error.maxlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Tempat terbit maksimal 50 karakter
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.placepublished.$error.pattern">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Tempat terbit hanya boleh berisi huruf, angka dan spasi
 			     	</font>
 			    </div>
 			    <select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="bookcategory" ng-model="bookcategory" required>
  		    		<option value="" disabled selected>Kategori Buku</option>
      				<?php
                          for ($i=1; $i <= count($Variable['Kategori_Buku']); $i++) 
                          { 
                             ?> <option value="<?=$Variable['Kategori_Buku'][$i];?>"><?=$Variable['Kategori_Buku'][$i];?></option> <?php
                          }
                    ?>
      			</select>
      			<div ng-show="addBookForm.bookcategory.$touched && addBookForm.bookcategory.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Kategori buku masih kosong
 			     	</font>
 			    </div>
 			   	<div class="border-input">
      				<input type="text" placeholder="Jumlah Buku" name="numberofbook" ng-model="numberofbook" ng-pattern="/^[0-9]*$/" ng-minlength="1" ng-maxlength="5000" required> 
      			</div>
      			<div ng-show="addBookForm.numberofbook.$touched && addBookForm.numberofbook.$error.required">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Jumlah buku masih kosong
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.numberofbook.$error.minlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Jumlah buku minimal terdapat 1 buku
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.numberofbook.$error.maxlength">
 			     	<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	  Jumlah buku maksimal terdapat 5000 buku
 			     	</font>
 			    </div>
 			    <div ng-show="addBookForm.numberofbook.$error.pattern">
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
      			<div class="crop-area-res">
      				<img ng-src="{{croppedBookImg}}"/>
      			</div>
        		
        		<button class="buttonUpload" ngf-select ng-model="bookimg" accept="image/*" required> 
        			<label for="file"><i class="fa fa-upload fa-1x"></i> Upload Gambar</label>
        		</button>
      			<br>
      			<div ng-show="addBookForm.$valid">
                    <button type="submit" class="buttonSubmit" ng-click="secretaryAddBook(croppedBookImg, bookimg.name)">Tambah Buku</button>
                </div>
                <div ng-show="!addBookForm.$valid">
                    <button type="submit" class="buttonSubmit" style="cursor: not-allowed;" disabled>Tambah Buku</button>
                </div>
      	  <?php } ?>
      	</ng-form>
    </div>
  </div>
</span>
</body>