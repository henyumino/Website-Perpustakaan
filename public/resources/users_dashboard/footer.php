<?php defined('resources_footer') OR exit('No direct script access allowed.'); ?>
<script src="<?=$Variable['URL'];?>loader.php/fah6872aagc87he40d9903g4d9e1a11d7c75d17e0bee73de6h/b2a728283e3534d.js"></script>
<script src="<?=$Variable['URL'];?>loader.php/9bfac60220g8bb2695e745ag8cb98292b9296h1d1h4a5hddb0/59ec7c7ecc9hf94.js"></script>
<script type="text/javascript">
	$('.side-menu').css('height','850px');
  $('.main-dash').css({
    'height':'auto',
    'min-height':'710px'
  });
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
</script>
</html>