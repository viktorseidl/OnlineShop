<?php
class Slideshow{
  private   $_db,
            $_data;

  public function __construct(){
      $this->_db=DB::getInstance();
  }
  public function getSlide($name=null){
    $data = $this->_db->get('slider', array('name', '=', $name));
    if($data->count()){
      $this->_data=$data->first();
      return $this->_data;
    }
  }
  public function updateSlide($name=null, $fields=array()){
    $table='slider';
    if(!$this->_db->update($table, "name='$name'", $fields)){
      throw new Exception('Fehler beim Update');
    }
    return true;
  }
}
?>
