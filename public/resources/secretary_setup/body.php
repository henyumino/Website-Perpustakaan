<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="setupSecretaryApp" ng-controller="setupSecretaryController">
<h2>Konfigurasi Akun</h2>

Anda perlu mengatur katasandi anda agar anda bisa mengakses akun anda. Diharapkan cuma anda saja yang 
mengetahui katasandi yang anda buat.<br/><br/>

<form method="POST" name="setupSecretaryForm">
 <table>
 	<tr>
 		<td>
 			<label>Katasandi</label>
 		</td>
 		<td>
 			<input type="password" name="password" ng-model="password" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required>
 		</td>
 		<td>
 			<div ng-show="setupSecretaryForm.password.$touched && setupSecretaryForm.password.$error.required">
 				<font style="color:red">Katasandi masih kosong</font>
 			</div>
 			<div ng-show="setupSecretaryForm.password.$error.minlength">
 				<font style="color:red">Katasandi minimal 5 karakter</font>
 			</div>
 			<div ng-show="setupSecretaryForm.password.$error.maxlength">
 				<font style="color:red">Katasandi maksimal 25 karakter</font>
 			</div>
 			<div ng-show="setupSecretaryForm.password.$error.pattern">
 				<font style="color:red">Katasandi hanya boleh berisi huruf dan angka</font>
 			</div>
 		</td>
 	</tr>
 	<tr>
 		<td>
 			<label>Konfirmasi Katasandi</label>
 		</td>
 		<td>
 			<input type="password" name="confirmpassword" ng-model="confirmpassword" ng-minlength="5" ng-maxlength="25" ng-pattern="/^[a-zA-Z-0-9]*$/" required>
 		</td>
 		<td>
 			<div ng-show="setupSecretaryForm.confirmpassword.$touched && setupSecretaryForm.confirmpassword.$error.required">
 				<font style="color:red">Konfirmasi katasandi masih kosong</font>
 			</div>
 			<div ng-show="setupSecretaryForm.confirmpassword.$error.minlength">
 				<font style="color:red">Konfirmasi katasandi minimal 5 karakter</font>
 			</div>
 			<div ng-show="setupSecretaryForm.confirmpassword.$error.maxlength">
 				<font style="color:red">Konfirmasi katasandi maksimal 25 karakter</font>
 			</div>
 			<div ng-show="setupSecretaryForm.confirmpassword.$error.pattern">
 				<font style="color:red">Konfirmasi katasandi hanya boleh berisi huruf dan angka</font>
 			</div>
      <div ng-show="setupSecretaryForm.confirmpassword.$touched && confirmpassword != password">
        <font style="color:red">Konfirmasi katasandi berbeda dengan katasandi</font>
      </div>
 		</td>
 	</tr>
 	<tr>
 		<td></td>
 		<td>
 			<div ng-if="setupSecretaryForm.$valid">
 			  <div ng-if="password == confirmpassword">
 				<button type="submit" ng-click="setupSecretary()">Perbaharui</button>
 			  </div>
 			  <div ng-if="password != confirmpassword">
 				<button type="submit" disabled>Perbaharui</button>
 			  </div>
 			</div>
 			<div ng-if="!setupSecretaryForm.$valid">
 				<button type="submit" disabled>Perbaharui</button>
 			</div>
 		</td>
 	</tr>