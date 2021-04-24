<?php

class Category{
  private $_db,
          $_table='kategorie',
          $_data;

  public function __construct(){
    $this->_db=DB::getInstance();
  }
  public function newKat($name=null){
    if(!$this->_db->insert($this->_table, $name)){
      throw new Exception('Fehler beim Update');
    }
    return true;
  }
  public function updateKat($name=null, $fields=array()){
    if(is_numeric($name)){
      $identifier="id='$name'";
    }else{
      $identifier="top_kat='$name'";
    }
    if(!$this->_db->update($this->_table,$identifier, $fields)){
      throw new Exception('Fehler beim Update');
    }
    return true;
  }
  public function getKat($where=null){
    if(is_numeric($where)){
      $search=array('id', '=', $where);
      $data = $this->_db->get($this->_table, $search);
      if($data->count()){
        $this->_data=$data->first();
        return $this->_data;
      }
    }else{
      $data = $this->_db->query("SELECT * from kategorie order by top_kat asc",array());
      if($data->count()){
        $this->_data=$data->results();
        return $this->_data;
      }
    }

  }
  public function deleteKat($name=null){
    if(!$this->_db->delete($this->_table,array('id','=',$name))){
      throw new Exception('Fehler beim Update');
    }
    return true;
  }

}

?>
