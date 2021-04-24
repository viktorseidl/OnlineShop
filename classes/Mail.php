<?php
class Mail{
  public static function send($mail,$typ,$data=array){
    $email_exp='/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    (isset($mail)&&(preg_match($email_exp,$mail)){
      switch($typ){
        case 'activation':
        break;
        case 'newpass':
        break;
        case 'changepass':
        break;
        case 'changemail':
        break;
        case 'order':
        break;
        case 'shipping':
        break;
        default:
        return false;
        break;
      }
    } return false;
  }
}
?>
