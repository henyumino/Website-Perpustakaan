<body ng-app="secretaryLoginApp" ng-controller="secretaryLoginController">
  <div class="wrapper">
  	<div class="form-input">
  	  <div class="form">
  	  	<h2 style="text-align:center; padding-top:100px; color:#000;">Login Sekretaris</h2>
		   <form method="POST" name="secretaryLoginform">
			  <input type="text" class="input_sekretaris" placeholder="Email" name="email" ng-model="email" ng-minlength="15" ng-maxlength="50" ng-pattern="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/" required><br/>
				<div ng-show="secretaryLoginform.email.$touched && secretaryLoginform.email.$error.required">
 					<font style="color:red;display:inline-block;color:red;width:100%;top:10px;left:-100px;margin:10px;position:relative;">Email masih kosong</font>
 				</div>
 				<div ng-show="secretaryLoginform.email.$error.minlength">
 					<font style="color:red;display:inline-block;color:red;width:100%;top:10px;left:-50px;margin:10px;position:relative;">Email minimal terdapat 15 karakter</font>
 				</div>
 				<div ng-show="secretaryLoginform.email.$error.maxlength">
 					<font style="color:red;display:inline-block;color:red;width:100%;top:10px;left:-40px;margin:10px;position:relative;">Email maksimal terdapat 60 karakter</font>
 				</div>
 				<div ng-show="secretaryLoginform.email.$error.pattern">
 					<font style="color:red;display:inline-block;color:red;width:100%;top:10px;left:-32px;margin:10px;position:relative;">Format email yang anda masukkan salah</font>
 				</div>
			<input type="password" name="password" class="input_sekretaris" placeholder="Password" ng-model="password" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required><br/>
				<div ng-show="secretaryLoginform.password.$touched && secretaryLoginform.password.$error.required">
 					<font style="color:red;display:inline-block;color:red;width:100%;top:10px;left:-85px;margin:10px;position:relative;">Katasandi masih kosong</font>
 				</div>
 				<div ng-show="secretaryLoginform.password.$error.minlength">
 					<font style="color:red;display:inline-block;color:red;width:100%;top:10px;left:-70px;margin:10px;position:relative;">Katasandi minimal 5 karakter</font>
 				</div>
 				<div ng-show="secretaryLoginform.password.$error.maxlength">
 					<font style="color:red;display:inline-block;color:red;width:100%;top:10px;left:-60px;margin:10px;position:relative;">Katasandi maksimal 25 karakter</font>
 				</div>
 				<div ng-show="secretaryLoginform.password.$error.pattern">
 					<font style="color:red;display:inline-block;color:red;width:100%;top:10px;left:-20px;margin:10px;position:relative;">Katasandi hanya boleh berisi huruf dan angka</font>
 				</div>
 				<input type="checkbox" class="check-box" name="remember_me" ng-model="remember_me">
				  <p style="float:left; padding:16px 10px; font-size:12px; color:#000; letter-spacing:1px;">Ingat saya</p><br/><br/>
			<div ng-if="secretaryLoginform.$valid">
 				<button type="submit" class="submit" ng-click="scrLogin()">Masuk</button>
 			</div>
 			<div ng-if="!secretaryLoginform.$valid">
 				<button type="submit" class="submit" disabled style="cursor: not-allowed;">Masuk</button>
 			</div>
 		</form>
 		<br/>
 		<a class="link" style="text-align: center !important;float: none !important;" href="<?=$Variable['URL'];?>secretary/forgot_password/">Lupa Katasandi ?</a>
 		<br/>
 		<a class="link" href="<?=$Variable['URL'];?>"> <i class="fa fa-arrow-left"></i> Kembali ke halaman awal</a>
 	</div>
 	</div>
 </div>
</body>