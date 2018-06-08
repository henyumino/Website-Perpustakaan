<body ng-app="secretaryResetPasswordApp" ng-controller="secretaryResetPasswordController">
  <h2>Reset Password</h2>
  <form method="POST" name="secretaryResetPasswordForm">
 <table>
  <tr>
    <td>
      <label>Katasandi Baru</label>
    </td>
    <td>
      <input type="password" name="password" ng-model="password" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required>  
    </td>
    <td>
      <div ng-show="secretaryResetPasswordForm.password.$touched && secretaryResetPasswordForm.password.$error.required">
        <font style="color:red">Katasandi masih kosong</font>
      </div>
      <div ng-show="secretaryResetPasswordForm.password.$error.minlength">
        <font style="color:red">Katasandi minimal 5 karakter</font>
      </div>
      <div ng-show="secretaryResetPasswordForm.password.$error.maxlength">
        <font style="color:red">Katasandi maksimal 25 karakter</font>
      </div>
      <div ng-show="secretaryResetPasswordForm.password.$error.pattern">
        <font style="color:red">Katasandi hanya boleh berisi huruf dan angka</font>
      </div>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <div ng-if="secretaryResetPasswordForm.$valid">
        <button type="submit" ng-click="secretaryResetPassword()">Atur Ulang</button>
      </div>
      <div ng-if="!secretaryResetPasswordForm.$valid">
        <button type="submit" disabled>Atur Ulang</button>
      </div>
    </td>
  </tr>
 </table>
</form>
</body>