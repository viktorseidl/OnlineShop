<?php

class Tax{
  private $_db,
          $_data;

  public function __construct(){
    $this->_db = DB::getInstance();
  }
  public function updateTax($fields=array()){
    if(!$this->_db->update('taxes','1', $fields)){
      throw new Exception('Fehler beim Update');
    }
    return true;
  }
  public function getTax($where=null){
      $data = $this->_db->get('taxes', array('id', '=', '1'));
      if($data->count()){
        $full=$data->first();
        foreach (json_decode($full->tax_arr) as $key => $value) {
          if($key==$where){
            $this->_data=$value;
          }
        }
        return $this->_data;
      }
      return false;

  }
  public function getTaxList(){

    $data = $this->_db->get('taxes', array('id', '=', '1'));
    if($data->count()){
      $this->_data=$data->first();
      return json_decode($this->_data->tax_arr);
    }
    return false;

  }
  public function addTax($value=null){

    $arr=$this->getTaxList();
    array_push($arr, $value);
    if($this->updateTax(array('tax_arr' => json_encode($arr)))==True){
     return true;
    }
    return false;

  }
  public function deleteTax($where){
    $arr=$this->getTaxList();
    $newarr=array();
    foreach ($arr as $key => $value) {
      if($key==$where){

      }else{
        array_push($newarr, $value);
      }
    }
    if($this->updateTax(array('tax_arr' => json_encode($newarr)))==True){
     return true;
    }

  }

}





?>
