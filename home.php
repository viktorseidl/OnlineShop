<?php
require 'core/init.php';
$user=new User();
if($logged===false){
  Redirect::to('index.php');
}
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <title>Mein Shop - Mein Konto</title>
    <?php
    include 'includes/meta/generalmeta.php';

    include 'includes/css/generalcss.php';
    include 'includes/css/indexcss.php';

    include 'includes/js/generaljs.php';

    ?>
  </head>
  <body>
    <?php
    include 'includes/html/headers/header.php';
    include 'includes/html/bodys/indexhtml.php';
    include 'includes/html/footers/footer.php';
    ?>
  </body>
</html>
