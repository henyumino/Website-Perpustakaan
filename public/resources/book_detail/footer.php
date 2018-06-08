<?php defined('resources_footer') OR exit('No direct script access allowed.'); ?>
<script type="text/javascript">
	window.var = true;
	var _yGx1a = "<?=$Variable['Rating'];?>";
	var _qpJ1  = "<?=$Variable['Data']['ID_Buku'];?>";
	var _qpJ2  = "<?=$Variable['Data']['Judul_Buku'];?>";
	var _qpJ3  = "<?=$Variable['ID_Pengguna'];?>";
	var _qpJ4  = "<?=$Variable['Data']['Jumlah_Buku'];?>";
</script>
<script src="<?=$Variable['URL'];?>loader.php/7g7999bce5003ge1ed99eacfc4e19dh31ag4ed818023a6c3f3/309f4bf8766b7dd.js"></script>
<script src="<?=$Variable['URL'];?>loader.php/9bfac60220g8bb2695e745ag8cb98292b9296h1d1h4a5hddb0/59ec7c7ecc9hf94.js"></script>
<script type="text/javascript">
  $('.tab-des-detail').on('click',function(){
    $('.tab-des-detail').css('border-bottom','2px solid #25225a');
    $('.tab-des-buku').css('border-bottom','none');
    $('.isi-des').css('display','none');
    $('.detail-des').css('display','block');
  });
  $('.tab-des-buku').on('click',function(){
    $('.tab-des-detail').css('border-bottom','none');
    $('.tab-des-buku').css('border-bottom','2px solid #25225a');
    $('.isi-des').css('display','block');
    $('.detail-des').css('display','none');
  });
</script>
</html>