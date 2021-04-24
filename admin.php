<?php
require 'core/init.php';
$user=new User();
if($uState===false){
  Redirect::to('index.php');
}
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <title>Mein Shop - Admin-Bereich</title>
    <?php
    include 'includes/meta/generalmeta.php';

    include 'includes/css/generalcss.php';
    include 'includes/css/admincss.php';

    include 'includes/js/generaljs.php';
    include 'includes/js/adminjs.php';
    include 'includes/js/admin_sliderjs.php';
    include 'includes/js/admin_kategoryjs.php';
    include 'includes/js/admin_productjs.php';

    ?>
  </head>
  <body>
    <?php
    include 'includes/html/headers/header.php';
    include 'includes/html/bodys/adminhtml.php';
    include 'includes/html/footers/footer.php';
    ?>
  </body>
</html>
