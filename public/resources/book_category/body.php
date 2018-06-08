<?php defined('resources_body') OR exit('No direct script access allowed.');?>
<body ng-app="usersBookCategoryApp" ng-controller="usersBookCategoryController">
	<div class="side-menu">
    <div class="profile-box">
      <div class="user-photo"><img src="<?=$Variable['URL'];?>resources/assets/<?=$Variable['Data_Pengguna']['Folder_Pengguna'];?>/<?=$Variable['Data_Pengguna']['Foto_Pengguna'];?>" width="70" height="70"/></div>
      <span><?=$Variable['Data_Pengguna']['Nama'];?></span>
      <span>Pengguna</span>
    </div>
    <!-- menu -->
    <div class="cat">MAIN</div>
    <ul>
      <li id="nav1">
        <div class="menu-nav">
          <div class="icon-nav"><img src="<?=$Variable['URL'];?>resources/assets/icon/book.png"/></div>
          <div class="ket-nav" ng-click="GotoBookPage()">Buku</div>
        </div>
      </li>
      <li id="nav2">
        <div class="menu-nav">
          <div class="icon-nav"><img src="<?=$Variable['URL'];?>resources/assets/icon/book.png"/></div>
          <div class="ket-nav" ng-click="GotoMyBookPage()">Buku Saya</div>
        </div>
      </li>
    </ul>
  </div>
  <div class="menu-atas">
    <i class="fa fa-bars fa-2x" id="toggle-button"></i>
    <span>Halaman Pengguna</span>
    <div class="setting">
      <button type="button" name="button" ng-click="GotoAccountSettings()"><i class="fa fa-cog fa-1x"></i><span>Pengaturan<span></button>
      <button type="button" name="button" ng-click="GotoLogout()"><i class="fa fa-cog fa-1x"></i><span>Keluar<span></button>
    </div>
  </div>
  <div class="main-dash" id="buku">
    <span class="label-dash">Buku</span>
    <span class="ket-dash">Dashboard / Buku / Kategori : <?=$Variable['Kategori'];?></span>
    <hr class="garis-dash">
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
	<?php
			if (empty($Variable['List_Buku']) == false)
			{
				for ($i=1; $i <= count($Variable['List_Buku']); $i++) 
          		{
          			?>
          			<div class="book-wh">
          				<img src="<?=$Variable['URL'].'resources/assets/'.$Variable['List_Buku'][$i]['Folder_Buku'].'/'.$Variable['List_Buku'][$i]['Foto_Buku'];?>"/>
          				<div class="button-pinjam">
          					<a href="<?=$Variable['URL'].'dashboard/book.php?id='.$Variable['List_Buku'][$i]['ID_Buku'];?>"><span>PINJAM</span></a>
          				</div>
          			</div>
          			<?php
          		}
			}
			else
			{
				?>
            <div style="margin-top: 100px;">
              <center>Tidak ada buku</center>
            </div>
        <?php
			}
	?>
   <div class="pagging">
    <?php
              if ($Variable['Halaman_Paging'] < $Variable['Total_Halaman'])
              {
                ?> <a href="<?=$Variable['URL'].'dashboard/book_category.php?id='.$_GET['id'].'&page='.($Variable['Halaman_Paging']+1);?>" style="color: blue;">Selanjutnya</a> <?php
              }
              else
              {

              }

              if ($Variable['Halaman_Paging'] > $Variable['Total_Halaman'] OR $Variable['Halaman_Paging'] == 1)
              {

              }
              else
              {
                 ?> <a href="<?=$Variable['URL'].'dashboard/book_category.php?id='.$_GET['id'].'&page='.($Variable['Halaman_Paging']-1);?>" style="color: blue;">Sebelumnya</a> <?php
              } 
      ?>
      </div>
  <div ng-model="showResult" ng-show="showResult == true">
    <div ng-model="showTableResult" ng-show="showTableResult == true">
     <hr class="garis-dash">
      <div ng-model="getKeyword"><p style="margin-top: 15px;margin-left: 32px;width: 95%;">Hasil pencarian <strong>{{getKeyword}}</strong></p></div>
        <div class="book-wh" ng-repeat="data in resultSearch">
          <img ng-src="http://localhost:8080/projekuas/resources/assets/{{data.Folder_Buku}}/{{data.Foto_Buku}}"/>
            <div class="button-pinjam">
             <a ng-href="javascript:void(0)" ng-click="GotoBookDetail(data)"><span>PINJAM</span></a>
            </div>
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
</body>