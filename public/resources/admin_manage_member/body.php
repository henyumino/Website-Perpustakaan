<body ng-app="adminManageMemberApp" ng-controller="adminManageMemberController">
  <h2>Kelola Anggota Perpustakaan</h2>
  <a href="<?=$Variable['URL'];?>admin/dashboard/" style="text-decoration: none;">Dashboard</a>
  <br/>
  <br/>
  <form method="POST" name="addMemberForm">
 <table>
 	<tr>
 		<td></td>
 		<td>
 			<h3>Form Tambahkan Anggota</h3>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Nama Depan</label>
 		</td>
 		<td>
 			<input type="text" name="fname" ng-model="fname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>	
 		</td>
 		<td>
 			<div ng-show="addMemberForm.fname.$touched && addMemberForm.fname.$error.required">
 				<font style="color:red">Nama depan masih kosong</font>
 			</div>
 			<div ng-show="addMemberForm.fname.$error.minlength">
 				<font style="color:red">Nama depan minimal 3 karakter</font>
 			</div>
 			<div ng-show="addMemberForm.fname.$error.maxlength">
 				<font style="color:red">Nama depan maksimal 25 karakter</font>
 			</div>
 			<div ng-show="addMemberForm.fname.$error.pattern">
 				<font style="color:red">Nama depan hanya boleh berisi huruf dan spasi</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Nama Belakang</label>
 		</td>
 		<td>
 			<input type="text" name="lname" ng-model="lname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>
 		</td>
 		<td>
 			<div ng-show="addMemberForm.lname.$touched && addMemberForm.lname.$error.required">
 				<font style="color:red">Nama belakang masih kosong</font>
 			</div>
 			<div ng-show="addMemberForm.lname.$error.minlength">
 				<font style="color:red">Nama belakang minimal 3 karakter</font>
 			</div>
 			<div ng-show="addMemberForm.lname.$error.maxlength">
 				<font style="color:red">Nama belakang maksimal 25 karakter</font>
 			</div>
 			<div ng-show="addMemberForm.lname.$error.pattern">
 				<font style="color:red">Nama belakang hanya boleh berisi huruf dan spasi</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Tanggal Lahir</label>
 		</td>
 		<td>
 			<select name="dateofbirth" ng-model="dateofbirth" required>
 				<?php 
 					 for ($i=1; $i<= 31; $i++) 
 					 { 
 					 	?> <option value="<?=$i;?>"><?=$i;?></option>
 					 	<?php
 					 }
 				?>
 			</select>
 		</td>
 		<td>
 			<div ng-show="addMemberForm.dateofbirth.$touched && addMemberForm.dateofbirth.$error.required">
 				<font style="color:red">Tanggal lahir masih kosong</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Bulan Lahir</label>
 		</td>
 		<td>
 			<select name="monthofbirth" ng-model="monthofbirth" required>
 				<option value="" selected></option>
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
 		</td>
 		<td>			
 			<div ng-show="addMemberForm.monthofbirth.$touched && addMemberForm.monthofbirth.$error.required">
 				<font style="color:red">Bulan lahir masih kosong</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Tahun Lahir</label>
 		</td>
 		<td>
 			<select name="yearofbirth" ng-model="yearofbirth" required>
 				<?php 
 					 for ($i=1990; $i<= date("Y"); $i++) 
 					 { 
 					 	?> <option value="<?=$i;?>"><?=$i;?></option>
 					 	<?php
 					 }
 				?>
 			</select>
 		</td>
 		<td>
 			<div ng-show="addMemberForm.yearofbirth.$touched && addMemberForm.yearofbirth.$error.required">
 				<font style="color:red">Tahun lahir masih kosong</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Jenis Kelamin</label>
 		</td>
 		<td>
 			<p>
                <input type="radio" name="gender" ng-model="gender" value="Pria" required>
                <label for="check-man">Laki-Laki</label>
                <input type="radio" name="gender" ng-model="gender" value="Wanita" required>
                <label for="check-woman">Perempuan</label>
            </p>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Alamat</label>
 		</td>
 		<td>
 			<input type="text" name="address" ng-model="address" ng-minlength="10" ng-maxlength="50" ng-pattern="/^[a-zA-Z-0-9 ]*$/" required>
 		</td>
 		<td>
 			<div ng-show="addMemberForm.address.$touched && addMemberForm.address.$error.required">
 				<font style="color:red">Alamat masih kosong</font>
 			</div>
 			<div ng-show="addMemberForm.address.$error.minlength">
 				<font style="color:red">Alamat miniml terdapat 10 karakter</font>
 			</div>
 			<div ng-show="addMemberForm.address.$error.maxlength">
 				<font style="color:red">Alamat maksimal terdapat 50 karakter</font>
 			</div>
 			<div ng-show="addMemberForm.address.$error.pattern">
 				<font style="color:red">Alamat hanya boleh berisi huruf, angka, dan spasi</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Nomor Ponsel</label>
 		</td>
 		<td>
 			<input type="text" name="phonenumber" ng-model="phonenumber" ng-minlength="12" ng-maxlength="12" ng-pattern="/08?[0-9]{10}$/" required>
 		</td>
 		<td>
 			<div ng-show="addMemberForm.phonenumber.$touched && addMemberForm.phonenumber.$error.required">
 				<font style="color:red">Nomor ponsel masih kosong</font>
 			</div>
      <div ng-show="addMemberForm.phonenumber.$error.minlength">
        <font style="color:red">Nomor ponsel harus terdiri dari 12 digit</font>
      </div>
      <div ng-show="addMemberForm.address.$error.maxlength">
        <font style="color:red">Nomor ponsel harus terdiri dari 12 digit</font>
      </div>
 			<div ng-show="addMemberForm.phonenumber.$error.pattern">
 				<font style="color:red">Nomor ponsel hanya boleh berisi angka dan harus terdiri dari 12 digit</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Email</label>
 		</td>
 		<td>
 			<input type="text" name="email" ng-model="email" ng-minlength="15" ng-maxlength="50" ng-pattern="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/" required>
 		</td>
 		<td>
 			<div ng-show="addMemberForm.email.$touched && addMemberForm.email.$error.required">
 				<font style="color:red">Email masih kosong</font>
 			</div>
 			<div ng-show="addMemberForm.email.$error.minlength">
 				<font style="color:red">Email minimal 15 karakter</font>
 			</div>
 			<div ng-show="addMemberForm.email.$error.maxlength">
 				<font style="color:red">Email maksimal 50 karakter</font>
 			</div>
 			<div ng-show="addMemberForm.email.$error.pattern">
 				<font style="color:red">Format email yang anda masukkan salah</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Status</label>
 		</td>
 		<td>
 			<p>
                <input type="radio" name="role" ng-model="role" value="Sekretaris" required>
                <label for="check-secretary">Sekretaris</label>
                <input type="radio" name="role" ng-model="role" value="Bendahara" required>
                <label for="check-treasurer">Bendahara</label>
            </p>
 		</td>
 	</tr>
 	<tr>
 		<td></td>
 		<td>
 			<div ng-if="addMemberForm.$valid">
 				<button type="submit" ng-click="adminAddMember()">Tambahkan</button>
 			</div>
 			<div ng-if="!addMemberForm.$valid">
 				<button type="submit" disabled>Tambahkan</button>
 			</div>
 		</td>
 	</tr>
 </table>
</form>
  <br/>
<br/>
 <table align="center">
        <tr>
            <th style="padding:10px;margin:5px;">ID Anggota</th>
            <th style="padding:10px;margin:5px;">Nama</th>
            <th style="padding:10px;margin:5px;">Jenis</th>
            <th style="padding:10px;margin:5px;">Aksi</th>
        </tr>
   <?php

        if ($Variable['Data_Ditampilkan'] == 'Sekretaris')
        {
            if (empty($Variable['Data_Anggota']) == false)
            {
                for ($i=1; $i <= count($Variable['Data_Anggota']); $i++) 
                {    
                  ?>
                      <tr>
                        <td style="padding:10px;margin:5px;">
                          <?=$Variable['Data_Anggota'][$i]['ID_Sekretaris'];?>
                        </td>
                        <td style="padding:10px;margin:5px;">
                          <?=$Variable['Data_Anggota'][$i]['Nama_Sekretaris'];?>
                        </td>
                        <td style="padding:10px;margin:5px;">
                          Sekretaris
                        </td>
                        <td style="padding:10px;margin:5px;">
                           <a href="javascript:void(0)" ng-click="admindelRoleSecretary('<?=$Variable['Data_Anggota'][$i]['ID_Sekretaris'];?>')">Hapus Anggota</a>
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
                   <td align="center" style="padding:10px;margin:5px;">Tidak ada daftar Anggota yang dapat ditampilkan</td>
                   <td style="padding:10px;margin:5px;"></td>
                   <td style="padding:10px;margin:5px;"></td>
                 </tr>
             <?php
           }
        }
        else if ($Variable['Data_Ditampilkan'] == 'Bendahara')
        {
            if (empty($Variable['Data_Anggota']) == false)
            {
                for ($i=1; $i <= count($Variable['Data_Anggota']); $i++) 
                {    
                  ?>
                      <tr>
                        <td style="padding:10px;margin:5px;">
                          <?=$Variable['Data_Anggota'][$i]['ID_Bendahara'];?>
                        </td>
                        <td style="padding:10px;margin:5px;">
                          <?=$Variable['Data_Anggota'][$i]['Nama_Bendahara'];?>
                        </td>
                        <td style="padding:10px;margin:5px;">
                          Bendahara
                        </td>
                        <td style="padding:10px;margin:5px;">
                           <a href="javascript:void(0)" ng-click="admindelRoleTreasurer('<?=$Variable['Data_Anggota'][$i]['ID_Bendahara'];?>')">Hapus Anggota</a>
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
                   <td align="center" style="padding:10px;margin:5px;">Tidak ada daftar Anggota yang dapat ditampilkan</td>
                   <td style="padding:10px;margin:5px;"></td>
                   <td style="padding:10px;margin:5px;"></td>
                 </tr>
             <?php
           }
        }
        else if ($Variable['Data_Ditampilkan'] == 'Semuanya')
        {
            if (empty($Variable['Data_Anggota']) == false)
            {
                for ($i=1; $i <= count($Variable['Data_Anggota']); $i++) 
                {    
                  ?>
                      <tr>
                        <td style="padding:10px;margin:5px;">
                          <?=$Variable['Data_Anggota'][$i]['ID_Sekretaris'];?>
                        </td>
                        <td style="padding:10px;margin:5px;">
                          <?=$Variable['Data_Anggota'][$i]['Nama_Sekretaris'];?>
                        </td>
                        <td style="padding:10px;margin:5px;">
                          Sekretaris
                        </td>
                        <td style="padding:10px;margin:5px;">
                           <a href="javascript:void(0)" ng-click="admindelRoleSecretary('<?=$Variable['Data_Anggota'][$i]['ID_Sekretaris'];?>')">Hapus Anggota</a>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:10px;margin:5px;">
                          <?=$Variable['Data_Anggota'][$i]['ID_Bendahara'];?>
                        </td>
                        <td style="padding:10px;margin:5px;">
                          <?=$Variable['Data_Anggota'][$i]['Nama_Bendahara'];?>
                        </td>
                        <td style="padding:10px;margin:5px;">
                          Bendahara
                        </td>
                        <td style="padding:10px;margin:5px;">
                           <a href="javascript:void(0)" ng-click="admindelRoleTreasurer('<?=$Variable['Data_Anggota'][$i]['ID_Bendahara'];?>')">Hapus Anggota</a>
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
                   <td align="center" style="padding:10px;margin:5px;">Tidak ada daftar Anggota yang dapat ditampilkan</td>
                   <td style="padding:10px;margin:5px;"></td>
                   <td style="padding:10px;margin:5px;"></td>
                 </tr>
             <?php
           }
        }
     ?>
 </table>
     <center>
      <?php
              if ($Variable['Halaman_Paging'] < $Variable['Total_Halaman'])
              {
                ?> <a href="<?=$Variable['URL'].'secretary/book_statistic/?page='.($Variable['Halaman_Paging']+1);?>">Selanjutnya</a> <?php
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
                 ?> <a href="<?=$Variable['URL'].'secretary/book_statistic/?page='.($Variable['Halaman_Paging']-1);?>">Sebelumnya</a> <?php
              } 
      ?>
    </center>
<h2>Cari Anggota</h2>

Cari berdasarkan Nama Anggota

<br/><br/>
 <ng-form method="POST" name="searchMemberForm">
  <table>
    <tr>
      <td></td>
      <td>
        <input type="text" name="keyword" ng-model="keyword" required>
      </td>
      <td>
        <div ng-show="searchMemberForm.keyword.$touched && searchMemberForm.keyword.$error.required">
          <font style="color:red">Kata kunci masih kosong</font>
        </div>
      </td> 
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="radio" name="filtercariAnggota" ng-model="filtercariAnggota"  required value="Sekretaris">
          <label for="check-secretary">Sekretaris</label>
        <input type="radio" name="filtercariAnggota" ng-model="filtercariAnggota" required value="Bendahara">
          <label for="check-treasurer">Bendahara</label>
      </td>
      <td>
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <div ng-if="searchMemberForm.$valid">
          <button type="submit" ng-click="searchMember()">Cari</button>
        </div>
        <div ng-if="!searchMemberForm.$valid">
          <button type="submit" disabled>Cari</button>
        </div>
      </td>
    </tr> 
  </table>
 </ng-form>
 <div ng-model="showResult" ng-show="showResult == true">
   <div ng-model="showTableResult" ng-show="showTableResult == true">
    <div ng-model="filtercariAnggotaSearch1" ng-show="filtercariAnggotaSearch1">
    <table align="center">
        <tr>
            <th style="padding:10px;margin:5px;">ID Anggota</th>
            <th style="padding:10px;margin:5px;">Nama</th>
            <th style="padding:10px;margin:5px;">Jenis</th>
            <th style="padding:10px;margin:5px;">Aksi</th>
        </tr>
        <tr ng-repeat="data in resultSearch">
            <td style="padding:10px;margin:5px;">{{data.ID_Sekretaris}}</td>
            <td style="padding:10px;margin:5px;">{{data.Nama_Sekretaris}}</td>
            <td style="padding:10px;margin:5px;">Sekretaris</td>
            <td style="padding:10px;margin:5px;"><a ng-href="javascript:void(0)" ng-click="adminDeleteRoleSecretary(data)">Hapus Anggota</a></td>
        </tr>
    </table>
  </div>
   </div>
   <div ng-model="filtercariAnggotaSearch2" ng-show="filtercariAnggotaSearch2">
    <table align="center">
        <tr>
            <th style="padding:10px;margin:5px;">ID Anggota</th>
            <th style="padding:10px;margin:5px;">Nama</th>
            <th style="padding:10px;margin:5px;">Jenis</th>
            <th style="padding:10px;margin:5px;">Aksi</th>
        </tr>
        <tr ng-repeat="data in resultSearch">
            <td style="padding:10px;margin:5px;">{{data.ID_Bendahara}}</td>
            <td style="padding:10px;margin:5px;">{{data.Nama_Bendahara}}</td>
            <td style="padding:10px;margin:5px;">Bendahara</td>
            <td style="padding:10px;margin:5px;"><a ng-href="javascript:void(0)" ng-click="adminDeleteRoleTreasurer(data)">Hapus Anggota</a></td>
        </tr>
    </table>
  </div>
   <div ng-model="showTextResult" ng-show="showTextResult == true">
     <div ng-model="no_result" align="center">
       Tidak ada Anggota dengan nama <strong>{{no_result}}</strong>
     </div>
   </div>
 </div>
</ng-form>
</body>