<?php
class Validate{
  private $_passed,
          $_errors=array(),
          $_db = null;

  public function __construct(){
    $this->_db= DB::getInstance();
  }
  public function check($source, $items = array()){
    foreach($items as $item => $rules){
      switch ($item) {
        case 'username':
        $bezeichner='Benutzername';
        break;
        case 'pass':
        $bezeichner='Password';
        break;
        case 'pass1':
        $bezeichner='Password wiederholen';
        break;
        case 'mail':
        $bezeichner='E-Mail';
        break;
        case 'mail1':
        $bezeichner='E-Mail wiederholen';
        break;
        default:
          // code...
          break;
      }
        foreach($rules as $rule => $rule_value){
            $value = trim($source[$item]);
            $item = escape($item);

            if($rule === 'required' && empty($value)){
              $this->addError("{$bezeichner} muss ausgefüllt sein");
            }else if(!empty($value)){
              switch($rule){
                case 'min':
                  if(strlen($value)< $rule_value){
                    $this->addError("{$bezeichner} muss mindestens {$rule_value} Buchstaben lang sein");
                  }
                break;
                case 'max':
                if(strlen($value)> $rule_value){
                  $this->addError("{$bezeichner} muss kleiner als {$rule_value} Buchstaben lang sein");
                }
                break;
                case 'matches':
                  if($value != $source[$rule_value]) {
                    if($rule_value=="pass"){
                      $efield='Passwort';
                    }else{
                      $efield='E-mail';
                    }
                    $this->addError("{$efield} muss gleich sein mit {$bezeichner}");
                  }
                break;
                case 'unique':
                $check=$this->_db->get($rule_value, array($item, '=', $value));
                if($check->count()){
                  $this->addError("{$bezeichner} existiert bereits bitte ändern");
                }
                break;
                default:
                break;
              }
            }
        }
    }
    if(empty($this->_errors)){
      $this->_passed = true;
    }
    return $this;

  }
  public function addError($error){
    $this->_errors[]= $error;
  }
  public function error(){
    return $this->_errors;
  }
  public function passed(){
    return $this->_passed;
  }
}
?>
