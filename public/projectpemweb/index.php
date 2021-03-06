<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="index.css">
	<link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="icons/simple-line-icons.css">
    
	<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
</head>
<body>
	<div class="wrapper-header">
		<div class="container">
			<div class="text-header">
				<ul>
					<li class="regis">Register</li>
					<li class="log">Login</li>
				</ul>
			</div>
			<div class="overlay"></div>
				<div class="text-wrapper">
					<div class="text">
						<p>The Important of Knowledge</p>
						<p>For Life</p>
						<p class="lol">LETS EXPLORE</p>
						<a> <i class="fa fa-angle-down" ></i></a>
					</div>
				</div>
		</div>
		<div class="container2" id="contain2">
			<div class="textcontainer2">
				<p>Kelebihan</p>
				<center><div class="underline"></div></center>
			</div>	
			<div class="kcontainer">
				<div class="kelebihan1">
					<center>
						<span class="icon-rocket"></span>
					</center>
            		<h3>Cepat</h3>
            		<p>Pelayanan yang terbilang</p>
            		<p>cukup cepat</p>
				</div>
				<div class="kelebihan1">
					<center>
						<span class="icon-check"></span>
					</center>
					<h3>Lengkap</h3>
            		<p>Terjamin kelengkapan buku</p>
            		<p>yang ada</p>
				</div>
				<div class="kelebihan1">
					<center>
						<span class="icon-like"></span>
					</center>
					<h3>Mudah</h3>
            		<p>Mudah dalam proses</p>
            		<p>peminjaman buku</p> 
				</div>
			</div>
		</div>
		<div class="container3">
			<div class="kotak1-2">
				<div class="gambar1">
					<div class="content">
						<div class="img"><img src="book.jpg"></div>
					</div>
					<div class="textcontent">
						<div class="title">Menginstimulasi Mental</div>
						<div class="isi" style="text-align: justify;">Otak merupakan salah satu organ tubuh yang memerlukan latihan agar tetap kuat dan sehat seperti organ tubuh yang lainnya. Dengan membaca buku dapat menjaga otak agar bisa tetap aktif sehingga dapat melakukan fungsinya secara baik dan benar</div>
					</div>
				</div>
				<div class="gambar2">
					<div class="content2">
						<div class="img"><img src="book.jpg"></div>
					</div>
					<div class="textcontent2">
						<div class="title">Mengurangi Stress</div>
						<div class="isi" style="text-align: justify;">Dengan melakukan kegiatan membaca yang bisa dilakukan selama beberapa menit dapat membantu menekan perkembangan hormon stress seperti hormon kortisol. Dengan membaca dapat membuat pikiran lebih santai sehingga hal tersebut dapat membantu menurunkan tingkat stress hingga 67%</div>
					</div>
				</div>
			</div>
		 	<div class="kotak3-4">
		 	<div class="gambar1">
		 		<div class="content">
		 			<div class="img"><img src="book.jpg"></div>
		 		</div>
		 		<div class="textcontent">
		 			<div class="title">Wawasan dan Pengetahuan</div>
						<div class="isi" style="text-align: justify;">Dengan membaca buku dapat mengisi kepala kita tentang berbagai macam informasi baru yang selama ini belum kita ketahui yang kemungkinan besar hal tersebut dapat berguna bagi kita nantinya. Semakin banyak pengetahuan yang kita miliki</div>
		 		</div>
		 	</div>
		 	<div class="gambar2">
		 		<div class="content2">
		 			<div class="img"><img src="book.jpg"></div>
		 		</div>
		 		<div class="textcontent2">
		 			<div class="title">Kualitas Memori</div>
						<div class="isi" style="text-align: justify;">Dengan membaca buku dapat memberikan andil untuk meningkatkan kualitas otak kita dalam proses mengingat, berbagai macam hal yang telah kita baca. Misalnya saja karakter, latar belakang, ambisi, sejarah, maupun berbagai macam unsur atau plot dari setiap alur cerita</div>
		 		</div>
		 	</div>
		 	</div>
		</div>
		<div class="container4">
			<div class="last">
			<div class="overlayf"></div>
				<div class="text-last">
					<p>Ingin Segera Meminjam Buku?</p>
					<p class="lel">Daftar Sekarang!</p>
				</div>	
			</div>
			<div class="wrapper-footer">
				<div class="footer">
					<div class="fb"><img src="facebook.png"></div>
					<div class="fb"><img src="instagram.png"></div>
					<div class="fb"><img src="search.png"></div>
					<div class="fb"><img src="twitter.png"></div>
					<div class="fb"><img src="whatsapp.png"></div>
				</div>
			</div>
		</div>
		<div class="footer-last">
			<ul>
				<li>ABOUT</li>
				<li>CONTACT</li>
				<li>ADVERTISE</li>
				<li>PRIVACY</li>
				<LI>TERMS</LI>
			</ul>
			<div class="copyright"><p>2018 Perpusnusantara | All Right Heserved</p></div>
		</div>
	</div>
    
    <script>
    	$(".fa-angle-down").click(function() {
			$('html, body').animate({
				scrollTop: $("#contain2").offset().top
			}, 1000);
		});
    </script>
</body>
</html>