<?php defined('resources_footer') OR exit('No direct script access allowed.'); ?>
<script src="<?=$Variable['URL'];?>loader.php/9bfac60220g8bb2695e745ag8cb98292b9296h1d1h4a5hddb0/59ec7c7ecc9hf94.js"></script>
<script type="text/javascript">
	var status = 'show';
  $('#toggle-button').on('click',function(){
    $('.side-menu').toggle();
    if (status=='show') {
      var width = $(window).width();
      if(width == 720){
        $('.main-dash').css('width','470px');
      }
      else{
        $('.main-dash').css({
          'margin':'0',
          'width':'1350px',
          // 'transition':'0.7s'
        });
      }
      status = 'hide';
    }
    else {
      status = 'show';
      $('.main-dash').css({
        'margin':'0',
        'width':'1095px',
        // 'transition':'0.7s'
      });
    }
  });

  $('#button-cat').on('click',function(){
    $('#add-cat').css('display','block');
  });
  $('#close-cat').on('click',function(){
    $('#add-cat').css('display','none');
  });
</script>
<script type="text/javascript">
	window.var = true;
	var _jQx1f = "<?=$Variable['Data']['ID_Buku'];?>";
	var _jQx2f = "<?=$Variable['Data']['Judul_Buku'];?>";
	var _jQx3f = "<?=$Variable['Data']['Deskripsi_Buku'];?>";
	var _jQx4f = "<?=$Variable['Data']['Nama_Pengarang'];?>";
	var _jQx5f = "<?=$Variable['Data']['Penerbit_Buku'];?>";
	var _jQx6f = "<?=$Variable['Data']['Tanggal_Terbit'];?>";
	var _jQx7f = "<?=$Variable['Data']['Bulan_Terbit'];?>";
	var _jQx8f = "<?=$Variable['Data']['Tahun_Terbit'];?>";
	var _jQx9f = "<?=$Variable['Data']['Tempat_Terbit'];?>";
	var _jQx10f = "<?=$Variable['Data']['Kategori_Buku'];?>";
	var _jQx11f = "<?=$Variable['Data']['Jumlah_Buku'];?>";
</script>
<script src="<?=$Variable['URL'];?>loader.php/56975fd5fec072d4170h303de9gg8g09f079fd397f0654ae53/cf37d18987b5499.js"></script>
</html>