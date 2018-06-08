<body ng-app="usersTodoApp" ng-controller="usersTodoController">
  <div class="menu-atas">
    <span><p style="margin: 30px 10px;">Halaman Pengguna</p></span>
    <div class="setting">
      <button type="submit" name="button" ng-click="GotoDashboardPage()"><i class="fa fa-cog fa-1x"></i><span>Dashboard<span></span></span></button>
      <button type="button" name="button" ng-click="GotoLogout()"><i class="fa fa-sign-out fa-1x"></i><span>Keluar<span></button>
    </div>
  </div>
  <div class="confirm-box">
    <span class="confirm-title">Konfirmasi Peminjaman</span>
    <hr class="garis-dash">
    <div class="confirm-box-isi">
      <div class="confirm-box-code">
        <span>Kode Peminjaman : <?=$_GET['code'];?></span>
      </div>
      <div class="confirm-box-tos">
        <p> User <strong><?=$Variable['Data_Pengguna']['Nama'];?></strong> silahkan melakukan peminjaman buku tersebut di perpustakaan kami. Anda telah melakukan proses peminjaman buku yang berjudul <strong><?=$Variable['Data_Buku']['Judul_Buku'];?></strong>, silahkan melakukan peminjaman buku tersebut di perpustakaan kami dengan cara seperti berikut ini.</p>
      </div>
      <div class="confirm-box-list">
        <ol type="1">
          <li>Catat kode peminjaman buku anda yang tertera diatas atau kodenya <strong><?=$_GET['code'];?></strong> atau bisa anda foto / screenshoot agar mudah.</li>
          <li>Silahkan membawa data diri anda seperti foto copy kartu pelajar ataupun KTP.</li>
          <li>Pergi ke perpustakaan kami yang beralamat di Jalan Pulau Belitung No 38.</li>
          <li>Temui sekretaris perpustakaan  dan katakan ingin meminjam buku. Katakan sudah melakukan peminjaman buku secara online dan berikan kode peminjaman buku ke sekretaris.</li>
          <li>Pihak sekretaris akan mengecek kode peminjaman buku anda. Jika memang benar maka anda dapat meminjam buku sesuai dengan buku yang sudah anda pilih.</li>
        </ol>
      </div>
      <span class="confirm-text">Silahkan periksa halaman <a href="<?=$Variable['URL'];?>my_book/" style="color: blue;;">Buku Saya</a> untuk memeriksa pengembalian buku yang anda pinjam.</span>
      <span class="confirm-text"><b>Pemberitahuan</b> silahkan membaca mengenai <a href="#" style="color: blue;;">ketentuan mengenai peminjaman buku</a> agar mengetahui ketentuan apa saja dalam peminjaman buku.</span>
    </div>
  </div>
</body>