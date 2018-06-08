<?php defined('resources_footer') OR exit('No direct script access allowed.'); ?>
<script type="text/javascript">
	window.var  = true;
	var _aFgQ1	= "<?=$_GET['borrow_code'];?>";
	var _aFgQ2  = "<?=$Variable['Data']['ID_Buku'];?>";
	var _aFgQ3  = "<?=$Variable['Data']['Jumlah_Buku'];?>";
	var _aFgQ4  = "<?=$Variable['Data_Pengguna']['ID_Pengguna'];?>";
</script>
<script src="<?=$Variable['URL'];?>loader.php/49g046ggb01eh2339g06deb0fde70c38cdfg974ag7a0f8b08b/02h0d54a2g5716h.js"></script>
<script src="<?=$Variable['URL'];?>loader.php/9bfac60220g8bb2695e745ag8cb98292b9296h1d1h4a5hddb0/59ec7c7ecc9hf94.js"></script>
<script type="text/javascript">
  var i;
  for(i = 1; i <= 7;i++){
    $('.pinjam-buku').append('<option value="'+i+'">'+i+' Hari</option>');
  }
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