<?php
require 'core/init.php';
$errMsg='';
$errframe='none';

if(Input::exists()){

      if(Token::check(Input::get('token'))){
            if(Input::get('type')=="login"){
              //LOGIN
                    $validate=new Validate();
                    $validation =$validate->check($_POST, array(
                      'username' => array(
                        'required' => true,
                        'min'      => 5,
                        'max'      => 25
                      ),
                      'pass'    => array(
                        'required'  => true,
                        'min'       => 8,
                        'max'       => 12
                      )
                    ));

                    if($validation->passed()){
                          $remember = (Input::get('remember') === 'on') ? true : false;
                          $login  = $user->login(htmlspecialchars(Input::get('username')), htmlspecialchars(Input::get('pass')), $remember);
                          if($login)  {
                              Redirect::to('home.php');
                          }else{
                              $errMsg='Login fehlgeschlagen';
                              $errframe='inline-block';

                          }
                    }else{
                          $errMsg='<ul>';
                          foreach($validation->error() as $error){
                              $errMsg.='<li>'.$error.'</li>';
                          }
                          $errMsg.='</ul>';
                          $errframe='inline-block';

                    }
            }else{
                    //REGISTER
                    $validate=new Validate();
                    $validation =$validate->check($_POST, array(
                      'username' => array(
                        'required' => true,
                        'min'      => 5,
                        'max'      => 25,
                        'unique' => 'users'
                      ),
                      'mail' => array(
                        'required' => true,
                        'min'      => 5,
                        'max'      => 70
                      ),
                      'mail1' => array(
                        'required' => true,
                        'min'      => 5,
                        'max'      => 70,
                        'matches'   => 'mail'
                      ),
                      'pass'    => array(
                        'required'  => true,
                        'min'       => 8,
                        'max'       => 12
                      ),
                      'pass1'    => array(
                        'required'  => true,
                        'min'       => 8,
                        'max'       => 12,
                        'matches'   => 'pass'
                      )
                    ));

                    if($validation->passed()){
                      $salt = Hash::salt(32);
                      $joined=time();
                      $ipAddress = $_SERVER['REMOTE_ADDR'];
                      if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
                          $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
                      }

                      try {

                          $user->create(array(
                                    'username'  =>  htmlspecialchars(Input::get('username')),
                                    'pass'      =>  Hash::make(Input::get('pass'),$salt),
                                    'skey'      =>  $salt,
                                    'mail'      =>  htmlspecialchars(Input::get('mail')),
                                    'ip_address'=>  htmlspecialchars($ipAddress),
                                    'joined'    =>  $joined,
                                    'groups'     =>  1
                          ),'users');
                          Session::flash('advert', 'signup_'.Input::get('username').'_'.Input::get('mail'));
                          Redirect::to('flash.php');
                          //
                      } catch (Exception $e)  {

                          die($e->getMessage());

                      }
                    }else{
                      $errMsg='<ul>';
                      foreach($validation->error() as $error){
                          $errMsg.='<li>'.$error.'</li>';
                      }
                      $errMsg.='</ul>';
                      $errframe='inline-block';

                    }
            }

      }else {
      Redirect::to('login.php');
      }
}
if(Input::exists()||(Input::exists('get'))){
if(Input::get('type')=='login'){
  $tokenGenerate=Token::generate();
  $userName='';
  if(Input::get('username')){
    $userName=Input::get('username');
  }
  $loglayout='
  <h3>Login</h3>
  <div class="errorhandler">
    <div class="inner-error">
      '.$errMsg.'
    </div>
  </div>
  <form id="login" action="login.php" method="post" enctype="multipart/form-data">
    <p><label for="username">Benutzername</label>
    <input type="text" name="username" placeholder="Benutzername" value="'.$userName.'"></p>
    <p><label for="pass">Passwort</label>
    <input type="password" name="pass" placeholder="Password"></p>
    <div class="be-logged">
    <hr><a>Eingeloggt bleiben?</a>
    <input checked="checked" style="float:left;padding:0;margin:0;box-shadow:none;" type="checkbox" name="remember" id="remember" >
    <a class="def-be-logged"><i class="fas fa-info-circle"></i> Hiermit wird ein Cookie auf Ihren Rechner erstellt, dass beim erneuten Besuch der Seite ausgelesen wird.</a>
    <br><br><br><hr><a style="margin-right:0.8em;"><i class="far fa-life-ring"></i></a><a class="forget-pass">Passwort vergessen?</a>
    </div>
    <input type="hidden" name="type" value="login">
    <input type="hidden" name="token" value="'.$tokenGenerate.'">
    <button form="login">Anmelden</button>
  </form>
  ';
}else{
  $tokenGenerate=Token::generate();
  $userName='';
  if(Input::get('username')){
    $userName=Input::get('username');
  }
  $userMail='';
  if(Input::get('mail')){
    $userMail=Input::get('mail');
  }
  $userMail1='';
  if(Input::get('mail1')){
    $userMail1=Input::get('mail1');
  }
  $loglayout='
  <h3>Registrierung</h3>
  <div class="errorhandler">
    <div class="inner-error">
      '.$errMsg.'
    </div>
  </div>
  <form id="login" action="login.php?type=signup" method="post" enctype="multipart/form-data">
    <p><label for="username">Benutzername</label>
    <input type="text" name="username" placeholder="Benutzername" value="'.$userName.'"></p>
    <p><label for="pass">Passwort</label>
    <input type="password" name="pass" placeholder="Password"></p>
    <p><label for="pass">Passwort wiederholen</label>
    <input type="password" name="pass1" placeholder="Password wiederholen"></p>
    <p><label for="pass">E-mail</label>
    <input type="text" name="mail" placeholder="E-mail Adresse" value="'.$userMail.'"></p>
    <p><label for="pass">E-mail wiederholen</label>
    <input type="text" name="mail1" placeholder="E-mail Adresse wiederholen" value="'.$userMail1.'"></p>
    <input type="hidden" name="type" value="signup">
    <input type="hidden" name="token" value="'.$tokenGenerate.'">
    <button form="login">Registrieren</button>
  </form>
  ';
}
}else{
  $tokenGenerate=Token::generate();
  $loglayout='
  <h3>Login</h3>
  <div class="errorhandler">
    <div class="inner-error">
      '.$errMsg.'
    </div>
  </div>
  <form id="login" action="login.php" method="post" enctype="multipart/form-data">
    <p><label for="username">Benutzername</label>
    <input type="text" name="username" placeholder="Benutzername"></p>
    <p><label for="pass">Passwort</label>
    <input type="password" name="pass" placeholder="Password"></p>
    <div class="be-logged">
    <hr><a>Eingeloggt bleiben?</a>
    <input checked="checked" style="float:left;padding:0;margin:0;box-shadow:none;" type="checkbox" name="remember" id="remember" >
    <a class="def-be-logged"><i class="fas fa-info-circle"></i> Hiermit wird ein Cookie auf Ihren Rechner erstellt, dass beim erneuten Besuch der Seite ausgelesen wird.</a>
    <br><br><br><hr><a style="margin-right:0.8em;"><i class="far fa-life-ring"></i></a><a class="forget-pass">Passwort vergessen?</a>
    </div>
    <input type="hidden" name="type" value="login">
    <input type="hidden" name="token" value="'.$tokenGenerate.'">
    <button form="login">Anmelden</button>
  </form>
  ';

}

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <title>Mein Shop - Login/Registrierung</title>
    <?php
    include 'includes/meta/generalmeta.php';

    include 'includes/css/generalcss.php';
    include 'includes/css/logincss.php';

    include 'includes/js/generaljs.php';

    ?>
  </head>
  <body>
    <?php
    include 'includes/html/headers/header.php';
    include 'includes/html/bodys/loginhtml.php';
    include 'includes/html/footers/footer.php';
    ?>
  </body>
</html>
