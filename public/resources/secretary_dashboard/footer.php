<?php defined('resources_footer') OR exit('No direct script access allowed.'); ?>
<script src="<?=$Variable['URL'];?>loader.php/2174ed920dbe45e8g6g11e10f3h8bheg3h9c638d96cc15bg03/7103bh82g8a61h5.js"></script>
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


  $('.tambah-buku').on('click',function(){
    $('#tambah-buku').css('display','block');
    $('#kelola-buku').css('display','none');
    $('#statistik').css('display','none');
    $('.side-menu').css('height','1140px');
  });
  $('#tambah-buku').css('display','none');
</script>
</html>