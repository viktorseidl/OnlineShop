<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
<script type="text/javascript">
function reDirect(page){
  if(page=="reg"){
    window.location='login.php?type=signup';
  }else{
    window.location=page;
  }
}
$(function(){
      run(1);
});
function run(n){
$(function(){

      if(n=='1'){

        $( '.inner-left-slider' ).hide();
        $( '.inner-right-slider' ).hide();
        $( '.inner-left-slider' ).html('<p><?php print($sliderObj->getSlide('slider_1')->l_text); ?></p>');
        $( '.inner-right-slider' ).html('<p><?php print($sliderObj->getSlide('slider_1')->r_text); ?></p><hr color="#000000" /><button onclick="reDirect(\'<?php print($sliderObj->getSlide('slider_1')->btn_red); ?>\')" ><?php print($sliderObj->getSlide('slider_1')->btn_text); ?></button>');
        $( '.inner-left-slider' ).fadeIn("slow");
        $( '.inner-right-slider' ).fadeIn("slow");
        setTimeout(function(){
          $( '.inner-left-slider' ).fadeOut(5000);
          $( '.inner-right-slider' ).fadeOut(5000);
          setTimeout(function(){  run('2'); },5000);
        },6000);
      }else if(n=='2'){
        $( '.inner-left-slider' ).hide();
        $( '.inner-right-slider' ).hide();
        $( '.inner-left-slider' ).html('<p><?php print($sliderObj->getSlide('slider_2')->l_text); ?></p>');
        $( '.inner-right-slider' ).html('<p><?php print($sliderObj->getSlide('slider_2')->r_text); ?></p><hr color="#000000" /><button onclick="reDirect(\'<?php print($sliderObj->getSlide('slider_2')->btn_red); ?>\')"><?php print($sliderObj->getSlide('slider_2')->btn_text); ?></button>');
        $( '.inner-left-slider' ).fadeIn("slow");
        $( '.inner-right-slider' ).fadeIn("slow");
        setTimeout(function(){
          $( '.inner-left-slider' ).fadeOut(5000);
          $( '.inner-right-slider' ).fadeOut(5000);
          setTimeout(function(){  run('3'); },5000);
        },6000);
      }else{
        $( '.inner-left-slider' ).hide();
        $( '.inner-right-slider' ).hide();
        $( '.inner-left-slider' ).html('<p><?php print($sliderObj->getSlide('slider_3')->l_text); ?></p>');
        $( '.inner-right-slider' ).html('<p><?php print($sliderObj->getSlide('slider_3')->r_text); ?></p><hr color="#000000" /><button onclick="reDirect(\'<?php print($sliderObj->getSlide('slider_3')->btn_red); ?>\')"><?php print($sliderObj->getSlide('slider_3')->btn_text); ?></button>');
        $( '.inner-left-slider' ).fadeIn("slow");
        $( '.inner-right-slider' ).fadeIn("slow");
        setTimeout(function(){
          $( '.inner-left-slider' ).fadeOut(5000);
          $( '.inner-right-slider' ).fadeOut(5000);
          setTimeout(function(){  run('1'); },5000);
        },6000);
      }
});
}

function register(){
  $(function(){

      $( '.action-inner' ).html('<h3>Registrierung</h3><div class="errorhandler"><div class="inner-error"></div></div><form id="login" action="login.php?type=signup" method="post" enctype="multipart/form-data"><p><label for="username">Benutzername</label><input type="text" name="username" placeholder="Benutzername"></p><p><label for="pass">Passwort</label><input type="password" name="pass" placeholder="Password"></p><p><label for="pass">Passwort wiederholen</label><input type="password" name="pass1" placeholder="Password wiederholen"></p><p><label for="pass">E-mail</label><input type="text" name="mail" placeholder="E-mail Adresse"></p><p><label for="pass">E-mail wiederholen</label><input type="text" name="mail1" placeholder="E-mail Adresse wiederholen"></p><input type="hidden" name="type" value="signup"><input type="hidden" name="token" value="<?php if(isset($tokenGenerate)){print($tokenGenerate);} ?>"><button form="login">Registrieren</button></form>');
      $('.inner-error').html('');
      $('.inner-error').css("display","none");

  });
}
$(function(){
  $( '.mymenu' ).click(function(event){
    $( '.hover-mymenu' ).toggle();
  });
});
$(function(){
  $( '.kat-menu-btn' ).click(function(event){
    $( '.kat-menu-hover' ).toggle();
  });
});

</script>
