<?php

class Hash{

public static function make($string, $salt=null){
  return hash('sha256', $string . $salt);
}
public static function salt($lenght){
  return bin2hex(random_bytes($lenght));
}
public static function unique($hash=null){
  return self::make(uniqid($hash));
}


}

?>
