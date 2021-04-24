<?php
require 'core/init.php';
$user=new User();
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <title>Mein Shop - Meine Bestellungen</title>
    <?php
    include 'includes/meta/generalmeta.php';

    include 'includes/css/generalcss.php';
    include 'includes/css/myorderscss.php';

    include 'includes/js/generaljs.php';

    ?>
  </head>
  <body>
    <?php
    include 'includes/html/headers/header.php';
    include 'includes/html/bodys/myordershtml.php';
    include 'includes/html/footers/footer.php';
    ?>
  </body>
</html>
