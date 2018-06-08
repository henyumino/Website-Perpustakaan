<body ng-app="adminDashboardApp" ng-controller="adminDashboardController">
	<div class="side-menu">
    <div class="profile-box-sekre">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Pemilik']['Folder_Pemilik'];?>/<?=$Variable['Data_Pemilik']['Foto_Pemilik'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Pemilik']['Nama'];?></span>
      <span>Pemilik</span>
    </div>
    <div class="cat">MAIN</div>
    <ul>
      <li id="nav1" style="background:#1e202c;">
        <div class="menu-nav">
          <div class="icon-nav"><img src="<?=$Variable['URL'];?>resources/assets/icon/addrole.png"/></div>
          <div class="ket-nav" ng-click="GotomanageMemberPage()">Kelola Anggota</div>
        </div>
      </li>
    </ul>
  </div>
  <div class="menu-atas">
    <i class="fa fa-bars fa-2x" id="toggle-button"></i>
    <span>Halaman Pemilik</span>
    <div class="setting">
      <button type="button" name="button" ng-click="GotoAccountSettings()"><i class="fa fa-cog fa-1x"></i><span>Pengaturan<span></button>
      <button type="button" name="button" ng-click="GotoLogout()"><i class="fa fa-sign-out fa-1x"></i><span>Keluar<span></button>
    </div>
  </div>
  <div class="main-dash" id="kelola-buku">
    <span class="label-dash">Kelola Anggota</span>
    <span class="ket-dash">Dashboard / Kelola Anggota / Sekretaris | <a href="<?=$Variable['URL'];?>admin/dashboard/index.php?secretaryList=hide&treasurerList=show" style="color: blue;">Bendahara</a></span>
    <div class="tambah-buku">
      <img src="<?=$Variable['URL'];?>resources/assets/icon/add-role.png">
    </div>
    <ng-form method="POST" name="searchSecretaryForm"> 
	   <div class="main-tab">
    	  <div class="search-cat">
    	  	<i class="fa fa-search fa-2x" ng-click="searchSecretaryForm.$valid ? searchSecretary() : errorSearchSecretary()"></i>
            <input placeholder="Cari Sekretaris Berdasarkan Nama" type="text" name="keyword" ng-model="keyword" required>
		  </div>
       </div>
    	<div ng-show="searchSecretaryForm.keyword.$touched && searchSecretaryForm.keyword.$error.required">
 			<font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			    Kata kunci masih kosong
 		    </font>
 		</div>
    </ng-form>
    <hr class="garis-dash">
    <div class="list-buku">
    <?php 
    	if (empty($Variable['Data_Sekretaris']) == false)
        {
        	?>

        	<table>
     	  	   <tr>
          		<td>Nama</td>
          		<td>Jenis</td>
          		<td>Aksi</td>
          	  </tr>
       <?php
        	for ($i=1; $i <= count($Variable['Data_Sekretaris']); $i++) 
            {
    ?>		 <tr>
          		<td><?=$Variable['Data_Sekretaris'][$i]['Nama_Sekretaris'];?></td>
        	    <td>Sekretaris</td>
          		<td><a href="javascript:void(0)" ng-click="admindelRoleSecretary('<?=$Variable['Data_Sekretaris'][$i]['ID_Sekretaris'];?>')" style="color:blue;">Hapus</a></td>
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
        	<span>Tidak ada anggota sekretaris yang dapat ditampilkan</span>
      	  </div>
    <?php
    	}
    ?>
    <div class="pagging">
    <?php
              if ($Variable['Halaman_Paging_Sekretaris'] < $Variable['Total_Halaman_Sekretaris'])
              {
                ?> <a href="<?=$Variable['URL'].'secretary/dashboard/index.php?secretaryList=show&treasurerList=hide&page_secretary='.($Variable['Halaman_Paging_Sekretaris']+1);?>" style="color: blue;">Selanjutnya</a> <?php
              }
              else
              {

              }

              if ($Variable['Halaman_Paging_Sekretaris'] > $Variable['Total_Halaman_Sekretaris'] OR $Variable['Halaman_Paging_Sekretaris'] == 1)
              {

              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'secretary/dashboard/index.php?secretaryList=show&treasurerList=hide&page_secretary='.($Variable['Halaman_Paging_Sekretaris']-1);?>" style="color: blue;">Sebelumnya</a> <?php
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
          		<td>Jenis</td>
          		<td>Aksi</td>
          	  </tr>
          	  <tr ng-repeat="data in resultSearch">
            	<td>{{data.Nama_Sekretaris}}</td>
            	<td>Sekretaris</td>
            	<td><a ng-href="javascript:void(0)" ng-click="adminDeleteRoleSecretary(data)" style="color: blue;">Hapus</a></td>
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
    <span class="label-dash">Tambah Anggota</span>
    <span class="ket-dash">Dashboard / Kelola Anggota / Tambah Anggota</span>
    <hr class="garis-dash">
    <div class="form-buku">
      <span class="label-dash">Tambah Anggota</span>
       <ng-form method="POST" name="addMemberForm">
 		    <div class="border-input">
      			<input type="text" placeholder="Nama Depan" type="text" name="fname" ng-model="fname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>
      		</div>
      		<div ng-show="addMemberForm.fname.$touched && addMemberForm.fname.$error.required">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nama depan masih kosong
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.fname.$error.minlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nama depan minimal 3 karakter
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.fname.$error.maxlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nama depan maksimal 25 karakter
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.fname.$error.pattern">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nama depan hanya boleh berisi huruf dan spasi
 			    </font>
 			</div>
 			<div class="border-input">
      			<input type="text" placeholder="Nama Belakang" type="text" name="lname" ng-model="lname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>
      		</div>
      		<div ng-show="addMemberForm.lname.$touched && addMemberForm.lname.$error.required">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nama belakang masih kosong
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.lname.$error.minlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nama belakang minimal 3 karakter
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.lname.$error.maxlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nama belakang maksimal 25 karakter
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.lname.$error.pattern">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nama belakang hanya boleh berisi huruf dan spasi
 			    </font>
 			</div>
 			<select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="dateofbirth" ng-model="dateofbirth" required>
  		    	<option value="" disabled selected>Tanggal Lahir</option>
      			<?php 
                    for ($i=1; $i<= 31; $i++) 
                    { 
                        ?> 
                        	<option value="<?=$i;?>"><?=$i;?></option>
                    	<?php
                    }
                ?>
      		</select>
      		<div ng-show="addMemberForm.dateofbirth.$touched && addMemberForm.dateofbirth.$error.required">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Tanggal lahir masih kosong
 			    </font>
 			</div>
 			<select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="monthofbirth" ng-model="monthofbirth" required>
  		    	<option value="" disabled selected>Tanggal Lahir</option>
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
           		<option value="Desember">Desember</option>
      		</select>
      		<div ng-show="addMemberForm.monthofbirth.$touched && addMemberForm.monthofbirth.$error.required">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Bulan lahir masih kosong
 			    </font>
 			</div>
 			<select style="margin: 10px 30px 0;width:310px;padding:8px;border-radius:5px;" name="yearofbirth" ng-model="yearofbirth" required>
  		    	<option value="" disabled selected>Tahun Lahir</option>
      			<?php 
                    for ($i=1990; $i<= date("Y"); $i++) 
                    { 
                        ?> 
                        	<option value="<?=$i;?>"><?=$i;?></option>
                    	<?php
                    }
                ?>
      		</select>
      		<div ng-show="addMemberForm.yearofbirth.$touched && addMemberForm.yearofbirth.$error.required">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Tahun lahir masih kosong
 			    </font>
 			</div>
			<div style="margin: 10px 30px 0;">
				<input type="radio" name="gender" ng-model="gender" value="Pria" required>
                <label for="check-man">Laki-Laki</label>
                <input type="radio" name="gender" ng-model="gender" value="Wanita" required>
                <label for="check-woman">Perempuan</label>
			</div> 	
			<div class="border-input">
      			<input placeholder="Alamat" type="text" name="address" ng-model="address" ng-minlength="10" ng-maxlength="50" ng-pattern="/^[a-zA-Z-0-9 ]*$/" required>
      		</div>
      		<div ng-show="addMemberForm.address.$touched && addMemberForm.address.$error.required">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Alamat masih kosong
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.address.$error.minlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Alamat minimal 10 karakter
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.fname.$error.maxlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Alamat maksimal 50 karakter
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.address.$error.pattern">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Alamat hanya boleh berisi huruf, angka dan spasi
 			    </font>
 			</div>
 			<div class="border-input">
      			<input placeholder="Nomor Ponsel" type="text" name="phonenumber" ng-model="phonenumber" ng-minlength="12" ng-maxlength="12" ng-pattern="/08?[0-9]{10}$/" required>
      		</div>
      		<div ng-show="addMemberForm.phonenumber.$touched && addMemberForm.phonenumber.$error.required">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nomor ponsel masih kosong
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.phonenumber.$error.minlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nomor ponsel harus terdiri dari 12 digit
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.phonenumber.$error.maxlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nomor ponsel harus terdiri dari 12 digit
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.phonenumber.$error.pattern">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Nomor ponsel hanya boleh berisi angka dan harus terdiri dari 12 digit
 			    </font>
 			</div>
 			<div class="border-input">
      			<input placeholder="Email" type="text" name="email" ng-model="email" ng-minlength="15" ng-maxlength="50" ng-pattern="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/" required>
      		</div>
      		<div ng-show="addMemberForm.email.$touched && addMemberForm.email.$error.required">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Email masih kosong
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.email.$error.minlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Email minimal 15 karakter
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.email.$error.maxlength">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Email minimal 50 karakter
 			    </font>
 			</div>
 			<div ng-show="addMemberForm.email.$error.pattern">
 			    <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:20px;margin:10px;position:relative;">
 			     	Format email yang anda masukkan salah
 			    </font>
 			</div>		
 			<div style="margin: 10px 0px 20px 30px;">
				<input type="radio" name="role" ng-model="role" value="Sekretaris" required>
                <label for="check-secretary">Sekretaris</label>
                <input type="radio" name="role" ng-model="role" value="Bendahara" required>
                <label for="check-treasurer">Bendahara</label>
			</div>
      		<div ng-show="addMemberForm.$valid">
                <button type="submit" class="buttonSubmit" ng-click="adminAddMember()">Tambahkan</button>
            </div>
            <div ng-show="!addMemberForm.$valid">
                <button type="submit" class="buttonSubmit" style="cursor: not-allowed;" disabled>Tambahkan</button>
            </div>
      	</ng-form>
    </div>
  </div>
</span>
</body>