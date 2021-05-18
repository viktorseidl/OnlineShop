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


      $search=array($colum, '=', $where);
      $data = $this->_db->get($table, $search);
      if($data->count()){
        $this->_data=$data->first();
        return $this->_data;
      }
      return false;

  }
  public function getProduktsList(){

    $data = $this->_db->query("SELECT id,name,p_type,p_stat from product order by id desc", array());

      if($data->count()){
        $this->_data=$data->results();
        return $this->_data;
      }
      return false;

  }
  public function copyRowProd($uid=null){
    $pname=$this->getProdukt('product',$uid)->name.'- Kopie';
    if($data = $this->_db->query("INSERT INTO product
        (kat_id, undKat_id, name, p_type,o_type,auction_time,dbuy,dpreis,price,newprice,rabattprice,tax_type,created_time,p_stat,describing,eigenschaften,p_quant,p_weight,p_width,p_height,p_deep,p_tagwort,variable_arr)
        SELECT
        kat_id, undKat_id,'$pname', p_type,o_type,auction_time,dbuy,dpreis,price,newprice,rabattprice,tax_type,created_time,'0',describing,eigenschaften,p_quant,p_weight,p_width,p_height,p_deep,p_tagwort,variable_arr
        FROM
        product
        WHERE
        id = '$uid'", array())){

          $this->_lastid=$this->_db->getLastID();
          $insID=$this->lastinsert();
          if($b=$this->_db->query("INSERT INTO p_images
              (pid,img_arr,front_img)
              SELECT
              '$insID', img_arr,front_img
              FROM
              p_images
              WHERE
              pid = '$uid'", array())){
            return true;
          }else{
            return false;
          }



    }
      return false;
  }
  public function copyRowImg($uid=null,$newid=null){

    if($data = $this->_db->query("INSERT INTO p_images
        (pid,img_arr,front_img)
        SELECT
        '$newid', img_arr,front_img
        FROM
        p_images
        WHERE
        pid = '$uid'", array())){
      return true;
    }
      return false;
  }
  public function getProduktsListByKat($kat=null){

    $data = $this->_db->query("SELECT id,name,p_type,p_stat from product where kat_id LIKE '%$kat%'  order by id desc", array());

      if($data->count()){
        $this->_data=$data->results();
        return $this->_data;
      }
      return false;

  }
  public function getProduktsListByArtnrName($name=null){
    if(is_numeric($name)){
      $data = $this->_db->query("SELECT id,name,p_type,p_stat from product where id='$name'  order by id desc", array());
    }else{
      $data = $this->_db->query("SELECT id,name,p_type,p_stat from product where name LIKE '$name%'  order by id desc", array());
    }

      if($data->count()){
        $this->_data=$data->results();
        return $this->_data;
      }
      return false;

  }
  public function getEigenschaften(){

    $data = $this->_db->query("SELECT * from p_eigenschaften", array());

      if($data->count()){
        $this->_data=$data->results();
        return $this->_data;
      }
      return false;

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
  public function deleteProduct($table=null,$where){

    if($table=='product'){
      if($data = $this->_db->query("DELETE FROM product WHERE id='$where'", array())){
        return TRUE;
      }
    }else{
      if($data = $this->_db->query("DELETE FROM p_images WHERE pid='$where'", array())){
        return TRUE;
      }
    }


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
