<?php

class Produkt{
  private $_db, 
          $_lastid,
          $_data;

  public function __construct(){
    $this->_db = DB::getInstance();
  }
  public function createProduct($table,$fields=array()){
    if(!$this->_db->insert($table, $fields)){
      //throw new Exception('Fehler beim Update');
    }
    $this->_lastid=$this->_db->getLastID();
    return true;

  }
  public function updateProduct($table,$name=null, $fields=array()){
    if($table=='p_images'){
      $colum="pid='$name'";
    }else{
      $colum="id='$name'";
    }
    if(!$this->_db->update($table,$colum, $fields)){
      throw new Exception('Fehler beim Update');
    }
    return true;
  }
  public function lastinsert(){
    return $this->_lastid;
  }
  public function getProdukt($table,$where=null){
    if($table=='p_images'){
      $colum='pid';
    }else if($table=='p_eigenschaften'){
      $colum='name';
    }else{
      $colum='id';
    }

    if(is_numeric($where)){
      $search=array($colum, '=', $where);
      $data = $this->_db->get($table, $search);
      if($data->count()){
        $this->_data=$data->first();
        return $this->_data;
      }
      return false;
    }
  }
  public function checkEigenschaft($where=null){

      $table='p_eigenschaften';
      $colum='name';
      $search=array($colum, '=', $where);
      $data = $this->_db->get($table, $search);
      if($data->count()){
        return TRUE;
      }
      return FALSE;

  }

}

  /*
  public function deleteProduct($where){
    if(is_numeric($where)){
      $identifier=array('id','=',$where);
    }else{
      $identifier=array('hash_id','=',$where);
    }
    if(!$this->_db->delete($this->_table,$identifier)){
      throw new Exception('Fehler beim Update');
    }
    return true;
  }
  public function getAllProduct($where){
    if(is_numeric($where)){
      $identifier='kat_id='.$where;
    }else{
      $identifier='p_tagwort Like %'.$where.' AND name Like %'.$where;
    }
    $data = $this->_db->query("SELECT * from product WHERE ".$identifier." order by top_kat asc", array());
    if($data->count()){
      $this->_data=$data->results();
      return $this->_data;
    }return false

  }*/



?>
