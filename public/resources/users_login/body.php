<body ng-app="usersLoginApp" ng-controller="usersLoginController">
 <div class="wrapper-login">
  <div class="form-login">
  	<span>Login</span>
	<form method="POST" name="usersLoginform">
	    <div class="border-input" style="margin-bottom: 5px;margin-left:40px;">
	   		<input type="text" placeholder="Email" name="email" ng-model="email" ng-minlength="15" ng-maxlength="50" ng-pattern="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/" required>
		</div>
		<div class="validasi-login">
			<div ng-show="usersLoginform.email.$touched && usersLoginform.email.$error.required">
 				<font style="color:red">Email masih kosong</font>
 			</div>
 		</div>
 		<div class="validasi-login">
 			<div ng-show="usersLoginform.email.$error.minlength">
 				<font style="color:red">Email minimal terdapat 15 karakter</font>
 			</div>
 		</div>
 		<div class="validasi-login">
 			<div ng-show="usersLoginform.email.$error.maxlength">
 				<font style="color:red">Email maksimal terdapat karakter</font>
 			</div>
 		</div>
 		<div class="validasi-login">
 			<div ng-show="usersLoginform.email.$error.pattern">
 				<font style="color:red">Format email yang anda masukkan salah</font>
 			</div>
 		</div>
 		<div class="border-input" style="margin-bottom: 5px;margin-left:40px;">
			<input type="password" placeholder="Password" name="password" ng-model="password" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required>
		</div>
		<div class="validasi-login">
			<div ng-show="usersLoginform.password.$touched && usersLoginform.password.$error.required">
 				<font style="color:red">Katasandi masih kosong</font>
 			</div>
 		</div>
 		<div class="validasi-login">	
 			<div ng-show="usersLoginform.password.$error.minlength">
 				<font style="color:red">Katasandi minimal 5 karakter</font>
 			</div>
 		</div>
 		<div class="validasi-login">
 			<div ng-show="usersLoginform.password.$error.maxlength">
 				<font style="color:red">Katasandi maksimal 25 karakter</font>
 			</div>
 		</div>
 		<div class="validasi-login">
 			<div ng-show="usersLoginform.password.$error.pattern">
 				<font style="color:red">Katasandi hanya boleh berisi huruf dan angka</font>
 			</div>
 		</div>
		<input type="checkbox" name="remember_me" ng-model="remember_me" style="margin: 20px 0px 10px 45px;"> Ingat Saya		
		<div class="forgot-password">
			<a href="<?=$Variable['URL'];?>forgot_password/" style="text-decoration:none;">Lupa Password ?</a>
		</div>
		<div ng-if="usersLoginform.$valid">
 			<button type="submit" ng-click="usrLogin()">Masuk</button>
 		</div>
 		<div ng-if="!usersLoginform.$valid">
 			<button type="submit" disabled style="cursor: not-allowed;">Masuk</button>
 		</div>
	</form>
  </div>
  <div class="vl"></div>
  <div class="motiv">
    <span>Reading make you</span><br>
    <span>Smarter then before</span>
    <p>"Semakin aku banyak membaca, semakin aku banyak berpikir, semakin aku banyak belajar, semakin aku sadar bahwa aku tak mengetahui apa pun."</p>
  </div>
</div>
</body>