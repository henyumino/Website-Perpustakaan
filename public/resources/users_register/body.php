<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="usersRegisApp" ng-controller="usersRegisController">
  <div id="container">
    </div>
    <div id="box-form"> 
      <h1 class="judulform">
        Buat Akun
      </h1>
      <p class="judulform-2">
        cobalah buat akun dan rasakan</br>sensasi membaca buku disini 
      </p>
      <div id="kotak-register">
        <form method="POST" name="usersRegisForm">
          <div id="formbody">
            <div class="row">
              <div class="col">
                <input placeholder="Nama Depan" type="text" name="fname" ng-model="fname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>
                <input placeholder="Nama belakang" type="text" name="lname" ng-model="lname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>
              </div>
            </div>
            <div ng-show="usersRegisForm.fname.$touched && usersRegisForm.fname.$error.required">
                <div class="row">
                  <div class="col" style="width: 50% !important;margin-right: 300px;">
                    <span class="error_register">Nama depan masih kosong</span>
                  </div>
                  <div class="col" style="width: 50% !important;margin-left: 300px;margin-top: -17px;">

                  </div>
               </div>
            </div>
            <div ng-show="usersRegisForm.lname.$touched && usersRegisForm.lname.$error.required">
                <div class="row">
                  <div class="col" style="width: 50% !important;margin-right: 300px;">

                  </div>
                  <div class="col" style="width: 50% !important;margin-left: 300px;margin-top: -17px;">
                    <span class="error_register">Nama belakang masih kosong</span>
                  </div>
               </div>
            </div>
            <div ng-show="usersRegisForm.fname.$error.minlength">
                <div class="row">
                  <div class="col" style="width: 50% !important;margin-right: 300px;">
                    <span class="error_register">Nama depan minimal 3 karakter</span>
                  </div>
                  <div class="col" style="width: 50% !important;margin-left: 300px;margin-top: -17px;">

                  </div>
               </div>
            </div>
            <div ng-show="usersRegisForm.lname.$error.minlength">
                <div class="row">
                  <div class="col" style="width: 50% !important;margin-right: 300px;">
                    
                  </div>
                  <div class="col" style="width: 50% !important;margin-left: 300px;margin-top: -20px;">
                    <span class="error_register">Nama belakang minimal 3 karakter</span>
                  </div>
               </div>
            </div>
            <div class="row">
              <select name="dateofbirth" class="date" required>
                <option value="" selected>Tanggal</option>
                  <?php 
                        for ($i=1; $i<= 31; $i++) 
                        { 
                         ?> 
                          <option value="<?=$i;?>"><?=$i;?></option>
                         <?php
                        }
                  ?>
              </select>
              <select name="monthofbirth" class="date" required>
                <option value="" selected>Bulan</option>
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
              <select name="yearofbirth" class="date" required>
                <option value="" selected>Tahun</option>
                <?php 
                      for ($i=1990; $i <= date("Y"); $i++) 
                      {   
                        ?> 
                          <option value="<?=$i;?>"><?=$i;?></option>
                        <?php
                      }
                ?>
              </select>
              <div class="row" style="display: block;">
                <div class="col">
                    <span class="error_register">Harus diisi</span>
                </div>
              </div>
              <div class="row" style="display: block;">
                <div class="col">
                    <span class="error_register">Harus diisi</span>
                </div>
              </div>
              <div class="row" style="display: block;">
                <div class="col">
                    <span class="error_register">Harus diisi</span>
                </div>
              </div>
            </div>
              <div id="gender" class="fix">
                <label class="container-2">Jenis Kelamin : </label>
                <label class="container-2">Laki-Laki
                   <input type="radio" name="gender" value="Pria" checked required>
                   <span class="checkmark"></span>
                </label>
                <label class="container-2">Perempuan
                  <input type="radio" name="gender" value="Pria" checked required>
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="row fix">
                 <input placeholder="Alamat" type="text" name="address" required>
                   <div class="error_register">Alamat masih kosong</div>
                   <div class="error_register">Alamat minimal terdapat 10 karakter</div>
                   <div class="error_register">Alamat maksimal terdapat 50 karakter</div>
                   <div class="error_register">Alamat hanya boleh berisi huruf, angka, dan spasi</div>
              </div>
              <div class="row">
                 <input placeholder="Nomor Ponsel" type="text" name="phonenumber" required>
                   <div class="error_register">Nomor ponsel kosong</div>
                   <div class="error_register">Nomor ponsel harus terdiri dari 12 digit</div>
                   <div class="error_register">Nomor ponsel harus terdiri dari 12 digit</div>
                   <div class="error_register">Nomor ponsel hanya boleh berisi angka dan harus terdiri dari 12 digit</div>
              </div>
              <div class="row">
                 <input placeholder="Email" type="text" name="email" required>
                   <div class="error_register">Email masih kosong</div>
                   <div class="error_register">Email minimal 15 karakter</div>
                   <div class="error_register">Email maksimal 50 karakter</div>
                   <div class="error_register">Format email yang anda masukkan salah</div>
              </div>
              <div class="row">
                 <input placeholder="Katasandi" type="password" name="password" required>
                   <div class="error_register">Katasandi masih kosong</div>
                   <div class="error_register">Katasandi minimal 5 karakter</div>
                   <div class="error_register">Katasandi maksimal 25 karakter</div>
                   <div class="error_register">Katasandi hanya boleh berisi huruf dan angka</div>
              </div>
              <div class="row">
                 <input placeholder="Konfirmasi katasandi" type="password" name="confirmpassword" required>
                 <div class="error_register">Konfirmasi katasandi masih kosong</div>
                 <div class="error_register">Konfirmasi katasandi minimal 5 karakter</div>
                 <div class="error_register">Konfirmasi katasandi maksimal 25 karakter</div>
                 <div class="error_register">Konfirmasi katasandi hanya boleh berisi huruf dan angka</div>
                 </div>
                 <div class="error_register" style="margin-left: 20px;margin-top: -7px;">Konfirmasi katasandi berbeda dengan katasandi</div>
              </div>
                <div class="row" style="margin-top: 650px;">
                 <button type="submit">Mendaftar</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
 <!--  <div id="container">
    <div id="box-picture">
      <h1 class="quotejudul">
        Membaca
      </h1>
      <p class="quotejudul-2">
        "Membaca buku diperpustakaan</br> kami memiliki sensasi yang berbeda</br> cobalah dan rasakan"
      </p>
    </div>
    <div id="box-form">
      <h1 class="judulform">
        Buat Akun
      </h1>
      <p class="judulform-2">
        cobalah buat akun dan rasakan</br>sensasi membaca buku disini 
      </p>
      <div id="kotak-register">
        <form method="POST" name="usersRegisForm">
          <div id="formbody">
            <div class="row">
              <div class="col">
                <input placeholder="Nama Depan" type="text" name="fname" ng-model="fname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required placeholder="">
                <input placeholder="Nama belakang" type="text" name="lname" ng-model="lname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required>
              </div>
            </div>
            <div class="row">
              <div ng-show="usersRegisForm.fname.$touched && usersRegisForm.fname.$error.required">
                <div class="col" style="width: 50% !important;">
                  <span class="error_register">Nama depan masih kosong</span>
                </div>
              </div>
              <div ng-show="usersRegisForm.fname.$error.minlength">
                <div class="col" style="width: 50% !important;">
                  <span class="error_register">Nama depan minimal 3 karakter</span>
                </div>
              </div>
              <div ng-show="usersRegisForm.fname.$error.maxlength">
                <div class="col" style="width: 50% !important;">
                  <span class="error_register">Nama depan maksimal 25 karakter</span>
                </div>
              </div>
              <div ng-show="usersRegisForm.fname.$error.pattern">
                <div class="col" style="width: 100% !important;margin-left: 90px !important;">
                  <span class="error_register">Nama depan maksimal 25 karakter</span>
                </div>
              </div>
              <div ng-show="usersRegisForm.lname.$touched && usersRegisForm.lname.$error.required">
                <div class="col" style="width: 50% !important;">
                  <span class="error_register">Nama belakang masih kosong</span>
                </div>
              </div>
              <div ng-show="usersRegisForm.lname.$error.minlength">
                <div class="col" style="width: 50% !important;">
                  <span class="error_register">Nama belakang minimal 3 karakter</span>
                </div>
              </div>
              <div ng-show="usersRegisForm.lname.$error.maxlength">
                <div class="col" style="width: 50% !important;">
                  <span class="error_register">Nama belakang maksimal 25 karakter</span>
                </div>
              </div>
              <div ng-show="usersRegisForm.lname.$error.pattern">
                <div class="col" style="width: 100% !important;margin-left: 90px !important;">
                  <span class="error_register">Nama depan maksimal 25 karakter</span>
                </div>
              </div>
            </div>
            <div class="row">
              <select name="dateofbirth" ng-model="dateofbirth" class="date" required>
                <option value="" selected>Tanggal</option>
                  <?php 
                        for ($i=1; $i<= 31; $i++) 
                        { 
                         ?> 
                          <option value="<?=$i;?>"><?=$i;?></option>
                         <?php
                        }
                  ?>
              </select>
              <select name="monthofbirth" ng-model="monthofbirth" class="date" required>
                <option value="" selected>Bulan</option>
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
              <select name="yearofbirth" ng-model="yearofbirth" class="date" required>
                <option value="" selected>Tahun</option>
                <?php 
                      for ($i=1990; $i <= date("Y"); $i++) 
                      {   
                        ?> 
                          <option value="<?=$i;?>"><?=$i;?></option>
                        <?php
                      }
                ?>
              </select>
              <div class="row">
                <div class="col" style="width: 33.33% !important;">
                  <div ng-show="usersRegisForm.dateofbirth.$touched && usersRegisForm.dateofbirth.$error.required">
                    <span class="error_register">Harus diisi</span>
                  </div>
                </div>
                <div class="col" style="width: 33.33% !important;">
                  <div ng-show="usersRegisForm.monthofbirth.$touched && usersRegisForm.monthofbirth.$error.required">
                    <span class="error_register">Harus diisi</span>
                  </div>
                </div>
                <div class="col" style="width: 33.33% !important;">
                  <div ng-show="usersRegisForm.yearofbirth.$touched && usersRegisForm.yearofbirth.$error.required">
                    <span class="error_register">Harus diisi</span>
                  </div>
                </div>
              </div>
            </div>
              <div id="gender" class="fix">
                <label class="container-2">Jenis Kelamin : </label>
                <label class="container-2">Laki-Laki
                   <input type="radio" name="gender" ng-model="gender" value="Pria" checked required>
                   <span class="checkmark"></span>
                </label>
                <label class="container-2">Perempuan
                  <input type="radio" name="gender" ng-model="gender" value="Pria" checked required>
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="row fix">
                 <input placeholder="Alamat" type="text" name="address" ng-model="address" ng-minlength="10" ng-maxlength="50" ng-pattern="/^[a-zA-Z-0-9 ]*$/" required>
                 <div ng-show="usersRegisForm.address.$touched && usersRegisForm.address.$error.required">
                   <div class="error_register">Alamat masih kosong</div>
                 </div>
                 <div ng-show="usersRegisForm.address.$error.minlength">
                   <div class="error_register">Alamat minimal terdapat 10 karakter</div>
                 </div>
                 <div ng-show="usersRegisForm.address.$error.maxlength">
                   <div class="error_register">Alamat maksimal terdapat 50 karakter</div>
                 </div>
                 <div ng-show="usersRegisForm.address.$error.pattern">
                   <div class="error_register">Alamat hanya boleh berisi huruf, angka, dan spasi</div>
                 </div>
              </div>
              <div class="row">
                 <input placeholder="Nomor Ponsel" type="text" name="phonenumber" ng-model="phonenumber" ng-minlength="12" ng-maxlength="12" ng-pattern="/08?[0-9]{10}$/" required>
                 <div ng-show="usersRegisForm.phonenumber.$touched && usersRegisForm.phonenumber.$error.required">
                   <div class="error_register">Nomor ponsel kosong</div>
                 </div>
                 <div ng-show="usersRegisForm.phonenumber.$error.minlength">
                   <div class="error_register">Nomor ponsel harus terdiri dari 12 digit</div>
                 </div>
                 <div ng-show="usersRegisForm.phonenumber.$error.maxlength">
                   <div class="error_register">Nomor ponsel harus terdiri dari 12 digit</div>
                 </div>
                 <div ng-show="usersRegisForm.phonenumber.$error.pattern">
                   <div class="error_register">Nomor ponsel hanya boleh berisi angka dan harus terdiri dari 12 digit</div>
                 </div>
              </div>
              <div class="row">
                 <input placeholder="Email" type="text" name="email" ng-model="email" ng-minlength="15" ng-maxlength="50" ng-pattern="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/" required>
                 <div ng-show="usersRegisForm.email.$touched && usersRegisForm.email.$error.required">
                   <div class="error_register">Email masih kosong</div>
                 </div>
                 <div ng-show="usersRegisForm.email.$error.minlength">
                   <div class="error_register">Email minimal 15 karakter</div>
                 </div>
                 <div ng-show="usersRegisForm.email.$error.maxlength">
                   <div class="error_register">Email maksimal 50 karakter</div>
                 </div>
                 <div ng-show="usersRegisForm.email.$error.pattern">
                   <div class="error_register">Format email yang anda masukkan salah</div>
                 </div>
              </div>
              <div class="row">
                 <input placeholder="Katasandi" type="password" name="password" ng-model="password" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required>
                 <div ng-show="usersRegisForm.password.$touched && usersRegisForm.password.$error.required">
                   <div class="error_register">Katasandi masih kosong</div>
                 </div>
                 <div ng-show="usersRegisForm.password.$error.minlength">
                   <div class="error_register">Katasandi minimal 5 karakter</div>
                 </div>
                 <div ng-show="usersRegisForm.password.$error.maxlength">
                   <div class="error_register">Katasandi maksimal 25 karakter</div>
                 </div>
                 <div ng-show="usersRegisForm.password.$error.pattern">
                   <div class="error_register">Katasandi hanya boleh berisi huruf dan angka</div>
                 </div>
              </div>
              <div class="row">
                 <input placeholder="Konfirmasi katasandi" type="password" name="confirmpassword" ng-model="confirmpassword" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required>
                 <div ng-show="usersRegisForm.confirmpassword.$touched && usersRegisForm.confirmpassword.$error.required">
                   <div class="error_register">Konfirmasi katasandi masih kosong</div>
                 </div>
                 <div ng-show="usersRegisForm.confirmpassword.$error.minlength">
                   <div class="error_register">Konfirmasi katasandi minimal 5 karakter</div>
                 </div>
                 <div ng-show="usersRegisForm.confirmpassword.$error.maxlength">
                   <div class="error_register">Konfirmasi katasandi maksimal 25 karakter</div>
                 </div>
                 <div ng-show="usersRegisForm.confirmpassword.$error.pattern">
                   <div class="error_register">Konfirmasi katasandi hanya boleh berisi huruf dan angka</div>
                 </div>
                 <div ng-show="usersRegisForm.confirmpassword.$touched && confirmpassword != password">
                   <div class="error_register">Konfirmasi katasandi berbeda dengan katasandi</div>
                 </div>
              </div>
        			<div ng-if="usersRegisForm.$valid">
               <div ng-if="password == confirmpassword">
                <div class="row">
   				       <button type="submit" ng-click="usersRegis()">Mendaftar</button>
                </div>
               </div>
               <div ng-if="password != confirmpassword">
                <div class="row">
                 <button type="submit" disabled style="cursor: not-allowed !important;">Mendaftar</button>
                </div>
               </div>
 			        </div>
 		         	<div ng-if="!usersRegisForm.$valid">
 				       <div class="row">
                 <button type="submit" disabled style="cursor: not-allowed !important;">Mendaftar</button>
 		         	  </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div> -->
</body>