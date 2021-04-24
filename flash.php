<?php
require 'core/init.php';
$ausgabe='';
if(Session::exists('advert')){
  $encFlash=explode('_', Session::flash('advert'));
  switch ($encFlash[0]) {
    case 'signup':
      $ausgabe='
      <div class="wrapper">
      Liebe/r <b>'.$encFlash[1].'</b>,<br>
      soeben wurde eine Freischaltungs-E-mail an deine Adresse <b>'.$encFlash[2].'</b> versendet.<br><br>
      Aus Sicherheitsgründen, musst Du dein neues Konto erst freischalten bevor Du dich in deinem Konto anmelden kannst.<br><br>
      Das MeinShop-Team wünscht Dir viel Spaß beim shoppen.
      </div>
      ';
      break;

    default:
      // code...
      break;
  }

}
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <title>Mein Shop</title>
    <?php
    include 'includes/meta/generalmeta.php';

    include 'includes/css/generalcss.php';
    include 'includes/css/flashcss.php';

    include 'includes/js/generaljs.php';

    ?>
  </head>
  <body>
    <?php
    include 'includes/html/headers/header.php';
    include 'includes/html/bodys/flashhtml.php';
    include 'includes/html/footers/footer.php';
    ?>
  </body>
</html>
