<?php
require 'core/init.php';
$user=new User();
if($user->logout()){
  Redirect::to('index.php');
}
?>
