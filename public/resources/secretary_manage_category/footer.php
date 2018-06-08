<?php defined('resources_footer') OR exit('No direct script access allowed.'); ?>
<script src="<?=$Variable['URL'];?>loader.php/8fb23h0a0e20h248e172c8hc273163f6bh967d1he23ag6g13d/h05aed8c15eg4a9.js"></script>
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
</html>