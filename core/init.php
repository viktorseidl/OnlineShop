<?php
session_start();

$GLOBALS['config']=array(
    'mysql' => array(
      'host' => 'localhost',
      'username' => 'root',
      'password' => '',
      'db' => 'shop'
    ),
    'remember' => array(
      'cookie_name' => 'hash',
      'cookie_expiry' => '604800'
    ),
    'session' => array(
      'session_name' => 'user',
      'token_name' => 'token'
    )
);
spl_autoload_register(
  function($class){
    require_once 'classes/'.$class.'.php';
  }
);
$sliderObj= new Slideshow;
include 'functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && ! Session::exists(Config::get('session/session_name'))){
  $hash= Cookie::get(Config::get('remember/cookie_name'));
  $hashCheck=DB::getInstance()->get('users_session', array('hash','=',$hash));

  if($hashCheck->count()){
    $user=new User($hashCheck->first()->user_id);
    $user->login();
  }
}
$user=new User();
if(!$user->isLoggedIn()){
$logged=false;
$connectbtns='
<div class="rowspan-mymenu" onclick="reDirect(\'login.php\')">
  <i class="fas fa-sign-in-alt"></i> Anmelden
</div>
<div class="rowspan-mymenu"  onclick="reDirect(\'reg\')">
  <i class="fas fa-user-plus"></i> Registrieren
</div>
';
$loggedinbtns='';
$uState=false;
}else{
  $logged=true;
  if($user->hasPermission('admin')){
    $uState=true;
    $adminBtn='<div class="rowspan-mymenu" onclick="reDirect(\'admin.php\')">
      <i class="fas fa-user-lock"></i> Admin
    </div>';
  }else{
    $uState=false;
    $adminBtn='';
  }
$connectbtns='';
$loggedinbtns=$adminBtn.'
<div class="rowspan-mymenu" onclick="reDirect(\'home.php\')">
  <i class="far fa-user-circle"></i> Konto
</div>
<div class="rowspan-mymenu" onclick="reDirect(\'myorders.php\')">
  <i class="fas fa-shopping-basket"></i> Bestellungen
</div>
<div class="rowspan-mymenu" onclick="reDirect(\'myinvoices.php\')">
  <i class="fas fa-file-invoice-dollar"></i> Rechnungen
</div>
<div class="rowspan-mymenu" onclick="reDirect(\'mytracking.php\')">
  <i class="fas fa-truck"></i> Versand
</div>
<div class="rowspan-mymenu" onclick="reDirect(\'logout.php\')">
  <i class="fas fa-sign-out-alt"></i> Logout
</div>';
}
?>
