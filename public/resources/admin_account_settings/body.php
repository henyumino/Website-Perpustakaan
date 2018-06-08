<body ng-app="adminAccountSettingsApp" ng-controller="adminAccountSettingsController">
  <div class="menu-atas">
    <span><p style="margin: 30px 10px;">Pengaturan Akun</p></span>
    <div class="setting">
      <button type="submit" name="button" ng-click="GotoDashboardPage()"><i class="fa fa-cog fa-1x"></i><span>Dashboard<span></span></span></button>
      <button type="button" name="button" ng-click="GotoLogout()"><i class="fa fa-sign-out fa-1x"></i><span>Keluar<span></button>
    </div>
  </div>
  <div class="setting-box">
  <label>Profil</label>
    <hr class="garis-dash">
        <div class="box-input-set">
           <ng-form method="POST" name="adminEditAccountForm">
                <span class="label-input">Nama Lengkap</span>
                <input type="text" type="text" name="fullname" data-ng-model="fullname" ng-pattern="/^[a-zA-Z ]*$/" ng-minlength="3" ng-maxlength="25" required style="margin: 10px 30px 0;width:295px;padding:8px;border-radius:5px;border: 1px solid grey;">
                <div ng-show="adminEditAccountForm.fullname.$touched && adminEditAccountForm.fullname.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                      Nama lengkap masih kosong
                  </font>
                </div>
                <div ng-show="adminEditAccountForm.fullname.$error.minlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Nama lengkap minimal 3 karakter
                  </font>
                </div>
                <div ng-show="adminEditAccountForm.fullname.$error.maxlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Nama lengkap maksimal 25 karakter
                  </font>
               </div>
               <div ng-show="adminEditAccountForm.fullname.$error.pattern">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Nama lengkap hanya boleh berisi huruf dan spasi
                  </font>
               </div>
               <span class="label-input">Tanggal Lahir</span>
               <select name="dateofbirth" data-ng-model="dateofbirth" required style="margin: 10px 30px 0;width:310px;height:35px;border-radius:5px;border: 1px solid grey;">
                 <?php 
                       for ($i=1; $i<= 31; $i++) 
                       { 
                  ?> 
                           <option value="<?=$i;?>"><?=$i;?></option>
                  <?php
                        }
                  ?>
               </select>
                <div ng-show="adminEditAccountForm.dateofbirth.$touched && adminEditAccountForm.dateofbirth.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                      Tanggal lahir masih kosong
                  </font>
                </div>
               <span class="label-input">Bulan Lahir</span>
               <select name="monthofbirth" data-ng-model="monthofbirth" required style="margin: 10px 46px 0;width:310px;height:35px;border-radius:5px;border: 1px solid grey;">
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
                <div ng-show="adminEditAccountForm.monthofbirth.$touched && adminEditAccountForm.monthofbirth.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                      Bulan lahir masih kosong
                  </font>
                </div>
                <span class="label-input">Tahun Lahir</span>
               <select name="yearofbirth" data-ng-model="yearofbirth" required style="margin: 10px 58px 0;width:310px;height:35px;border-radius:5px;border: 1px solid grey;">
                 <?php 
                       for ($i=1990; $i<= date("Y"); $i++) 
                       { 
                  ?> 
                           <option value="<?=$i;?>"><?=$i;?></option>
                  <?php
                        }
                  ?>
               </select>
                <div ng-show="adminEditAccountForm.yearofbirth.$touched && adminEditAccountForm.yearofbirth.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                      Tahun lahir masih kosong
                  </font>
                </div>
                <span class="label-input" id="moved-input-imp">Jenis Kelamin</span>
                  <input type="radio" name="gender" data-ng-model="gender" value="Pria" required style="margin-left: 39px;">
                  <span class="label-gender">Laki-Laki</span>
                  <input type="radio" name="gender" data-ng-model="gender" value="Wanita" required>
                  <span class="label-gender">Perempuan</span>
                <br/>
                <span class="label-input">Alamat</span>
                <input type="text" name="address" data-ng-model="address" ng-minlength="10" ng-maxlength="50" ng-pattern="/^[a-zA-Z-0-9 ]*$/" require required style="margin: 10px 95px 0;width:295px;padding:8px;border-radius:5px;border: 1px solid grey;">
                <div ng-show="adminEditAccountForm.address.$touched && adminEditAccountForm.address.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                      Alamat masih kosong
                  </font>
                </div>
                <div ng-show="adminEditAccountForm.address.$error.minlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Alamat minimal 10 karakter
                  </font>
                </div>
                <div ng-show="adminEditAccountForm.address.$error.maxlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Alamat maksimal 50 karakter
                  </font>
               </div>
               <div ng-show="adminEditAccountForm.address.$error.pattern">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Alamat hanya boleh berisi huruf, angka dan spasi
                  </font>
               </div>
               <br/>
               <span class="label-input">Nomor Ponsel</span>
                <input type="text" name="phonenumber" data-ng-model="phonenumber" ng-minlength="12" ng-maxlength="12" ng-pattern="/08?[0-9]{10}$/" required style="margin: 10px 37px 0;width:295px;padding:8px;border-radius:5px;border: 1px solid grey;">
                <div ng-show="adminEditAccountForm.phonenumber.$touched && adminEditAccountForm.phonenumber.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                      Nomor ponsel masih kosong
                  </font>
                </div>
                <div ng-show="adminEditAccountForm.phonenumber.$error.minlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Nomor ponsel harus terdiri dari 12 digit
                  </font>
                </div>
                <div ng-show="adminEditAccountForm.phonenumber.$error.maxlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Nomor ponsel harus terdiri dari 12 digit
                  </font>
               </div>
               <div ng-show="adminEditAccountForm.phonenumber.$error.pattern">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Nomor ponsel hanya boleh berisi angka dan harus terdiri dari 12 digit
                  </font>
               </div>
               <span class="label-input">Email</span>
                <input type="text" name="email" data-ng-model="email" ng-minlength="15" ng-maxlength="50" ng-pattern="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/" required style="margin: 10px 106px 0;width:295px;padding:8px;border-radius:5px;border: 1px solid grey;">
                <div ng-show="adminEditAccountForm.email.$touched && adminEditAccountForm.email.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                      Email masih kosong
                  </font>
                </div>
                <div ng-show="adminEditAccountForm.email.$error.minlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Email minimal 15 karakter
                  </font>
                </div>
                <div ng-show="adminEditAccountForm.email.$error.maxlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Email maksimal 50 karakter
                  </font>
               </div>
               <div ng-show="adminEditAccountForm.email.$error.pattern">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:300px;margin:10px;position:relative;">
                     Format email yang anda masukkan salah
                  </font>
               </div>
               <span class="label-input">Foto Profil</span>
               <div ng-show="!profilepicture">
                  <img src="<?=$Variable['URL'].'resources/assets/'.$Variable['Data']['Folder_Pemilik'].'/'.$Variable['Data']['Foto_Pemilik'];?>" style="width:180px;height:180px;margin:10px 0px 0px 310px">
              </div>
              <div ng-show="profilepicture">
                <div class="crop-area-res-1">
                  <img ng-src="{{croppedprofilepicture}}"/>
                </div>
              </div>
            </div>
            <div ng-show="!profilepicture">
              <div class="crop-area-1">
                  <div ngf-drop ng-model="profilepicture" ngf-pattern="image/*" class="cropArea">
                      <img-crop image="profilepicture  | ngfDataUrl" result-image="croppedprofilepicture" ng-init="croppedprofilepicture=''">
                      </img-crop>
                  </div>
               </div>
            </div>
            <div ng-show="profilepicture">
              <div class="crop-area-1a">
                  <div ngf-drop ng-model="profilepicture" ngf-pattern="image/*" class="cropArea">
                      <img-crop image="profilepicture  | ngfDataUrl" result-image="croppedprofilepicture" ng-init="croppedprofilepicture=''">
                      </img-crop>
                  </div>
               </div>
            </div>
               <button id="button-upload-setting" ngf-select ng-model="profilepicture" accept="image/*"> 
                    <label for="file"><i class="fa fa-upload fa-1x"></i> Ganti Foto</label>
               </button>
               <div ng-if="adminEditAccountForm.$valid">
               <button id="button-save-setting" type="submit" ng-click="adminEditAccount(croppedprofilepicture, profilepicture.name)">Perbaharui</button>
               </div>
               <div ng-if="!adminEditAccountForm.$valid">
               <button id="button-save-setting" type="submit" disabled>Perbaharui</button>
               </div>
          </ng-form>
          <div style="margin-top: 30px;">
             <label>Ganti Katasandi</label>
              <hr class="garis-dash">
            <span class="label-input">Katasandi Lama</span>
             <ng-form method="POST" name="adminChangePasswordForm">
                <input type="password" name="password" ng-model="password" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required style="margin: 10px 30px 0;width:295px;padding:8px;border-radius:5px;border: 1px solid grey;">
                <div ng-show="adminChangePasswordForm.password.$touched && adminChangePasswordForm.password.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:310px;margin:10px;position:relative;">
                      Katasandi lama masih kosong
                  </font>
                </div>
                <div ng-show="adminChangePasswordForm.password.$error.minlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:310px;margin:10px;position:relative;">
                     Katasandi lama minimal 5 karakter
                  </font>
                </div>
                <div ng-show="adminChangePasswordForm.password.$error.maxlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:310px;margin:10px;position:relative;">
                     Katasandi lama maksimal 25 karakter
                  </font>
               </div>
               <div ng-show="adminChangePasswordForm.password.$error.pattern">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:310px;margin:10px;position:relative;">
                     Katasandi lama hanya boleh berisi huruf dan angka
                  </font>
               </div>
               <span class="label-input">Katasandi Baru</span>
               <input type="password" name="newpassword" ng-model="newpassword" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required style="margin: 10px 37px 0;width:295px;padding:8px;border-radius:5px;border: 1px solid grey;">
                <div ng-show="adminChangePasswordForm.newpassword.$touched && adminChangePasswordForm.newpassword.$error.required">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:310px;margin:10px;position:relative;">
                      Katasandi baru masih kosong
                  </font>
                </div>
                <div ng-show="adminChangePasswordForm.newpassword.$error.minlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:310px;margin:10px;position:relative;">
                     Katasandi baru minimal 5 karakter
                  </font>
                </div>
                <div ng-show="adminChangePasswordForm.newpassword.$error.maxlength">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:310px;margin:10px;position:relative;">
                     Katasandi baru maksimal 25 karakter
                  </font>
               </div>
               <div ng-show="adminChangePasswordForm.newpassword.$error.pattern">
                  <font style="color:red;display:inline-block;color:red;width:100%;top:5px;bottom:5px;left:310px;margin:10px;position:relative;">
                     Katasandi baru hanya boleh berisi huruf dan angka
                  </font>
               </div>
               <div ng-if="adminChangePasswordForm.$valid">
               <button id="button-update-pass" type="submit" ng-click="adminChangePassword()">Ganti Katasandi</button>
               </div>
               <div ng-if="!adminChangePasswordForm.$valid">
               <button id="button-update-pass" type="submit" disabled>Ganti Katasandi</button>
               </div>
             </ng-form>
          </div>
        </div>
     </div>
  </body>