<body ng-app="secretaryForgotPasswordApp" ng-controller="secretaryForgotPasswordController">
    <center>
    <div class="box-forgot">
      <div class="forgot-pass">
        <span>Atur Ulang Katasandi</span>
        <div class="line"></div>
        <p>Masukkan email akun anda maka sistem akan mengirimkan tautan agar anda bisa mengatur ulang katasandi.</p>
         <form method="POST" name="secretaryForgotPasswordForm">
          <input placeholder="Email" style="margin-top: -20px !important;padding: 8px;" class="field-forgot" type="text" name="email" ng-model="email" ng-minlength="15" ng-maxlength="50" ng-pattern="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/" required>
           <div ng-show="secretaryForgotPasswordForm.email.$touched && secretaryForgotPasswordForm.email.$error.required">
             <font style="color:red;display: block;width: 100%;text-align: left;padding-top: 20px;padding-bottom: 10px;">Email masih kosong</font>
           </div>
           <div ng-show="secretaryForgotPasswordForm.email.$error.minlength">
             <font style="color:red;float:left;display: block;width: 100%;text-align: left;padding-top: 20px;padding-bottom: 10px;">Email minimal terdapat 15 karakter</font>
           </div>
           <div ng-show="secretaryForgotPasswordForm.email.$error.maxlength">
             <font style="color:red;display: block;width: 100%;text-align: left;padding-top: 20px;padding-bottom: 10px;">Email maksimal terdapat 50 karakter</font>
           </div>
           <div ng-show="secretaryForgotPasswordForm.email.$error.pattern">
             <font style="color:red;display: block;width: 100%;text-align: left;padding-top: 20px;padding-bottom: 10px;">Format email yang anda masukkan salah</font>
           </div>
           <div ng-if="secretaryForgotPasswordForm.$valid">
            <button type="submit" ng-click="secretaryForgotPassword()">Konfirmasi</button>
           </div>
           <div ng-if="!secretaryForgotPasswordForm.$valid">
            <button type="submit" style="cursor: not-allowed;" disabled>Konfirmasi</button>
           </div>
           <div style="margin-top: 50px;float:left;display: block;text-align: left;width: 100%;">
             <a href="<?=$Variable['URL'];?>login/" style="text-decoration:none;color: blue;">Kembali ke login</a>
           </div>
          </form>
      </div>
    </div>
  </center>
</body>