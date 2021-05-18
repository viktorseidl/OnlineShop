<?php
include 'globals.php';
$user= new User();
if($user->hasPermission('admin')){
  if(Input::exists()){
      $CatOBJ=new Category();
      $ProdOBJ=new Produkt();
      /*
      Image Upload Slider
      */
      if(Input::get('pid')){
      $pid=htmlspecialchars(Input::get('pid'));
      $x=0;
      $pic_arr=array();
      foreach($_FILES as $file){
        $x++;
            $fileName = $file["name"];
            $fileTmpLoc = $file["tmp_name"];
            $fileType = $file["type"];
            $fileSize = $file["size"];
            $fileErrorMsg = $file["error"];

                    $extention= explode(".", $fileName);
                    $extention= end($extention);
                    $fileName=sha1(Input::get('pid').$x).'.'.$extention;


            if(move_uploaded_file($fileTmpLoc, "../../img/products/$fileName")){
              array_push($pic_arr, $fileName);
            }
      }

      if($ProdOBJ->createProduct('p_images',array(
        'pid' => $pid,
        'img_arr' => json_encode($pic_arr)
      ))!=TRUE){
        echo 'NO';
        exit();
      }
      echo $pid;
      exit();


    }
    /*
    Image Upload Slider
    */
    if(Input::get('addmoreIMGpid')){
    $pid=htmlspecialchars(Input::get('addmoreIMGpid'));

    $pic_arr=json_decode($ProdOBJ->getProdukt('p_images', htmlspecialchars(Input::get('addmoreIMGpid')))->img_arr);
    $x=count($pic_arr);
    $c=0;
    $str='';
    foreach($_FILES as $file){
      $x++;
          $fileName = $file["name"];
          $fileTmpLoc = $file["tmp_name"];
          $fileType = $file["type"];
          $fileSize = $file["size"];
          $fileErrorMsg = $file["error"];

                  $extention= explode(".", $fileName);
                  $extention= end($extention);
                  $fileName=sha1($pid.$x).'.'.$extention;


          if(move_uploaded_file($fileTmpLoc, "../../img/products/$fileName")){
            if($c==count($_FILES)-1){
              $str.='"'.$fileName.'"';
            }else{
              $str.='"'.$fileName.'",';
            }

          }
          $c++;
    }
    $oldstr='';
    $t=0;
    foreach ($pic_arr as $value) {
      if($t==count($pic_arr)-1){
        $oldstr.='"'.$value.'"';
      }else{
        $oldstr.='"'.$value.'",';
      }
      $t++;
    }
    $arr='['.$oldstr.','.$str.']';

    if($ProdOBJ->updateProduct('p_images',$pid,array(
      'img_arr' => $arr
    ))!=TRUE){
      echo 'NO';
      exit();
    }
    echo $pid;
    exit();
  }

        /*
        Ausgabe des HTML
        */
        if(Input::get('Ausgabe')){

            $list='';
          foreach ($ProdOBJ->getProduktsList() as $value) {
            $idwert=str_split($value->id);
            $fullzero=8;
            $zeros=$fullzero-count($idwert);
            $wert='X';
            for ($i = 0; $i < $zeros; $i++) {
              $wert.='0';
            }
            $wert.=$value->id;
            $img=$ProdOBJ->getProdukt('p_images',$value->id);
            $imgarr=json_decode($img->img_arr);
            $imgsrc=$imgarr[$img->front_img];
            if($value->p_stat==1){
              $bclas='fas fa-toggle-on';
              $sytsta='style="color:#00FF00;"';
            }else{
              $sytsta='style="color:#FF0000;"';
              $bclas='fas fa-toggle-off';
            }
            $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows" style="height:3.5em;"><a><div style="display:inline-block;float:left;margin-left:0.3em;width:4em;height:3.5em;background-size:100% 100%;background-position:center;background-repeat:none;background-image:url(\'img/products/'.$imgsrc.'\')"></div> '.$value->name.'</a> | <span>Art-Nr:15454-'.$wert.'</span><i onclick="deleteProduct(\''.$value->id.'\')" class="fas fa-trash-alt"></i><i onclick="changeProductSettings(\''.$value->id.'\')" class="fas fa-edit"></i><i onclick="copyProductFull(\''.$value->id.'\')" class="far fa-copy"></i><i onclick="toogleONOFF(\''.$value->id.'\')" id="togleonoffpro'.$value->id.'" '.$sytsta.' class="'.$bclas.'"></i></div>';
          }
          $kats='';
          if($CatOBJ->getKat()){
              foreach ($CatOBJ->getKat() as $value) {

                $kats.='<option value="'.$value->id.'">'.$value->top_kat.'</option>';
              }
          }

          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Hier haben Sie die Möglichkeit, die Produkte Ihres Shops zu bearbeiten oder neue Produkte hinzuzufügen.</p>
            <div class="branding-name">Neues Produkt anlegen</div>

            <div class="fieldset">
            <div class="btn-int-admin" onclick="createNewProduct()">Neues Produkt erstellen</div>
            </div>
            <div class="branding-name">Bestehende Produkte löschen oder bearbeiten</div>
            <div class="fieldset">
            <input type="text" id="filterOnNameArtNr" onkeyup="filterOnNameArtNr()" placeholder="Produkt suchen (Name oder Artikel-Nr)"/>
            <select id="filterOnKat" onchange="filterOnKat()" style="margin-top:0.5em;"><option value="n">Kategorie anzeigen</option>'.$kats.'</select>
            </div>
            <div class="existing-sub" id="TopkastListdiv" style="width:90%;">
            '.$list.'
            </div>


          </div>
          ';
          echo $ausgabe;
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('filterOnKat')){
          $list='';
          if(Input::get('filterOnKat')=='n'){
            foreach ($ProdOBJ->getProduktsList() as $value) {
              $idwert=str_split($value->id);
              $fullzero=8;
              $zeros=$fullzero-count($idwert);
              $wert='X';
              for ($i = 0; $i < $zeros; $i++) {
                $wert.='0';
              }
              $wert.=$value->id;
              $img=$ProdOBJ->getProdukt('p_images',$value->id);
              $imgarr=json_decode($img->img_arr);
              $imgsrc=$imgarr[$img->front_img];
              if($value->p_stat==1){
                $bclas='fas fa-toggle-on';
                $sytsta='style="color:#00FF00;"';
              }else{
                $sytsta='style="color:#FF0000;"';
                $bclas='fas fa-toggle-off';
              }
              $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows" style="height:3.5em;"><a><div style="display:inline-block;float:left;margin-left:0.3em;width:4em;height:3.5em;background-size:100% 100%;background-position:center;background-repeat:none;background-image:url(\'img/products/'.$imgsrc.'\')"></div> '.$value->name.'</a> | <span>Art-Nr:15454-'.$wert.'</span><i onclick="deleteProduct(\''.$value->id.'\')" class="fas fa-trash-alt"></i><i onclick="changeProductSettings()" class="fas fa-edit"></i><i onclick="copyProductFull(\''.$value->id.'\')" class="far fa-copy"></i><i onclick="toogleONOFF(\''.$value->id.'\')" id="togleonoffpro'.$value->id.'" '.$sytsta.' class="'.$bclas.'"></i></div>';
            }
          }else{
              if($ProdOBJ->getProduktsListByKat(htmlspecialchars(Input::get('filterOnKat')))!=false){
                    foreach ($ProdOBJ->getProduktsListByKat(htmlspecialchars(Input::get('filterOnKat'))) as $value) {
                      $idwert=str_split($value->id);
                      $fullzero=8;
                      $zeros=$fullzero-count($idwert);
                      $wert='X';
                      for ($i = 0; $i < $zeros; $i++) {
                        $wert.='0';
                      }
                      $wert.=$value->id;
                      $img=$ProdOBJ->getProdukt('p_images',$value->id);
                      $imgarr=json_decode($img->img_arr);
                      $imgsrc=$imgarr[$img->front_img];
                      if($value->p_stat==1){
                        $bclas='fas fa-toggle-on';
                        $sytsta='style="color:#00FF00;"';
                      }else{
                        $sytsta='style="color:#FF0000;"';
                        $bclas='fas fa-toggle-off';
                      }
                      $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows" style="height:3.5em;"><a><div style="display:inline-block;float:left;margin-left:0.3em;width:4em;height:3.5em;background-size:100% 100%;background-position:center;background-repeat:none;background-image:url(\'img/products/'.$imgsrc.'\')"></div> '.$value->name.'</a> | <span>Art-Nr:15454-'.$wert.'</span><i onclick="deleteProduct(\''.$value->id.'\')" class="fas fa-trash-alt"></i><i onclick="changeProductSettings()" class="fas fa-edit"></i><i onclick="copyProductFull(\''.$value->id.'\')" class="far fa-copy"></i><i onclick="toogleONOFF(\''.$value->id.'\')" id="togleonoffpro'.$value->id.'" '.$sytsta.' class="'.$bclas.'"></i></div>';
                    }
              }else{
                $list ='<div id="TopTabedit" class="existing-sub-rows" style="text-align:center;height:3.5em;">Keine Produkte in Kategorie vorhanden</div>';
              }
          }

          echo $list;
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('filterOnNameArtNr')){
          $list='';
          if(trim(Input::get('filterOnNameArtNr'))==null){
            foreach ($ProdOBJ->getProduktsList() as $value) {
              $idwert=str_split($value->id);
              $fullzero=8;
              $zeros=$fullzero-count($idwert);
              $wert='X';
              for ($i = 0; $i < $zeros; $i++) {
                $wert.='0';
              }
              $wert.=$value->id;
              $img=$ProdOBJ->getProdukt('p_images',$value->id);
              $imgarr=json_decode($img->img_arr);
              $imgsrc=$imgarr[$img->front_img];
              if($value->p_stat==1){
                $bclas='fas fa-toggle-on';
                $sytsta='style="color:#00FF00;"';
              }else{
                $sytsta='style="color:#FF0000;"';
                $bclas='fas fa-toggle-off';
              }
              $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows" style="height:3.5em;"><a><div style="display:inline-block;float:left;margin-left:0.3em;width:4em;height:3.5em;background-size:100% 100%;background-position:center;background-repeat:none;background-image:url(\'img/products/'.$imgsrc.'\')"></div> '.$value->name.'</a> | <span>Art-Nr:15454-'.$wert.'</span><i onclick="deleteProduct(\''.$value->id.'\')" class="fas fa-trash-alt"></i><i onclick="changeProductSettings()" class="fas fa-edit"></i><i onclick="copyProductFull(\''.$value->id.'\')" class="far fa-copy"></i><i onclick="toogleONOFF(\''.$value->id.'\')" id="togleonoffpro'.$value->id.'" '.$sytsta.' class="'.$bclas.'"></i></div>';
            }
          }else{
              if(is_numeric(Input::get('filterOnNameArtNr'))){
                $getid=str_split(Input::get('filterOnNameArtNr'));
                $search='';
                foreach($getid as $value){
                  if($value=='0'){

                  }else{
                    $search.=$value;
                  }
                }
                if($ProdOBJ->getProduktsListByArtnrName(htmlspecialchars($search))!=false){
                      foreach ($ProdOBJ->getProduktsListByArtnrName(htmlspecialchars($search)) as $value) {
                        $idwert=str_split($value->id);
                        $fullzero=8;
                        $zeros=$fullzero-count($idwert);
                        $wert='X';
                        for ($i = 0; $i < $zeros; $i++) {
                          $wert.='0';
                        }
                        $wert.=$value->id;
                        $img=$ProdOBJ->getProdukt('p_images',$value->id);
                        $imgarr=json_decode($img->img_arr);
                        $imgsrc=$imgarr[$img->front_img];
                        if($value->p_stat==1){
                          $bclas='fas fa-toggle-on';
                          $sytsta='style="color:#00FF00;"';
                        }else{
                          $sytsta='style="color:#FF0000;"';
                          $bclas='fas fa-toggle-off';
                        }
                        $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows" style="height:3.5em;"><a><div style="display:inline-block;float:left;margin-left:0.3em;width:4em;height:3.5em;background-size:100% 100%;background-position:center;background-repeat:none;background-image:url(\'img/products/'.$imgsrc.'\')"></div> '.$value->name.'</a> | <span>Art-Nr:15454-'.$wert.'</span><i onclick="deleteProduct(\''.$value->id.'\')" class="fas fa-trash-alt"></i><i onclick="changeProductSettings()" class="fas fa-edit"></i><i onclick="copyProductFull(\''.$value->id.'\')" class="far fa-copy"></i><i onclick="toogleONOFF(\''.$value->id.'\')" id="togleonoffpro'.$value->id.'" '.$sytsta.' class="'.$bclas.'"></i></div>';
                      }
                }else{
                  $list ='<div id="TopTabedit" class="existing-sub-rows" style="text-align:center;height:3.5em;">Keine Produkte in Kategorie vorhanden</div>';
                }
              }else{
                  if($ProdOBJ->getProduktsListByArtnrName(htmlspecialchars(Input::get('filterOnNameArtNr')))!=false){
                        foreach ($ProdOBJ->getProduktsListByArtnrName(htmlspecialchars(Input::get('filterOnNameArtNr'))) as $value) {
                          $idwert=str_split($value->id);
                          $fullzero=8;
                          $zeros=$fullzero-count($idwert);
                          $wert='X';
                          for ($i = 0; $i < $zeros; $i++) {
                            $wert.='0';
                          }
                          $wert.=$value->id;
                          $img=$ProdOBJ->getProdukt('p_images',$value->id);
                          $imgarr=json_decode($img->img_arr);
                          $imgsrc=$imgarr[$img->front_img];
                          if($value->p_stat==1){
                            $bclas='fas fa-toggle-on';
                            $sytsta='style="color:#00FF00;"';
                          }else{
                            $sytsta='style="color:#FF0000;"';
                            $bclas='fas fa-toggle-off';
                          }
                          $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows" style="height:3.5em;"><a><div style="display:inline-block;float:left;margin-left:0.3em;width:4em;height:3.5em;background-size:100% 100%;background-position:center;background-repeat:none;background-image:url(\'img/products/'.$imgsrc.'\')"></div> '.$value->name.'</a> | <span>Art-Nr:15454-'.$wert.'</span><i onclick="deleteProduct(\''.$value->id.'\')" class="fas fa-trash-alt"></i><i onclick="changeProductSettings()" class="fas fa-edit"></i><i onclick="copyProductFull(\''.$value->id.'\')" class="far fa-copy"></i><i onclick="toogleONOFF(\''.$value->id.'\')" id="togleonoffpro'.$value->id.'" '.$sytsta.' class="'.$bclas.'"></i></div>';
                        }
                  }else{
                    $list ='<div id="TopTabedit" class="existing-sub-rows" style="text-align:center;height:3.5em;">Keine Produkte in Kategorie vorhanden</div>';
                  }
              }
          }

          echo $list;
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('new')){
          if($CatOBJ->getKat()){

            $list='<div class="existing-check-rows" >';
          foreach ($CatOBJ->getKat() as $value) {

            $list.='<div class="existing-checkboxes"><input type="checkbox" class="checkboxInp" value="'.$value->id.'" name="Kats[]" /> '.$value->top_kat.'</div>';
          }
          $list.='</div><div class="fieldset"><div class="btn-int-admin" onclick="saveStepOne()">Speichern und weiter >></div></div>';
          }else{

            $list='<div class="existing-check-rows" >
            <div class="existing-checkboxes">Keine Kategorie gefunden!<br><br>Bitte erstellen Sie zuerst eine Kategorie.<br><br><div class="fieldset"><div onclick="editKategory()" class="btn-int-admin">Kategorie anlegen</div></div>
            </div></div>';

          }

          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Bitte wählen Sie die Haupt-Kategorien aus.</p>
            <div class="branding-name">Haupt-Kategorien auswählen</div>
            '.$list.'
          </div>
          ';
          echo $ausgabe;
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('copyProductFull')){
          if($ProdOBJ->copyRowProd(htmlspecialchars(Input::get('copyProductFull')))!=false){
            $img_arr=json_decode($ProdOBJ->getProdukt('p_images', $ProdOBJ->lastinsert())->img_arr);
            $new_arr=array();
            $x=0;
            foreach ($img_arr as $value) {
              $extention= explode(".", $value);
              $extention= end($extention);
              $fileName=sha1($ProdOBJ->lastinsert().$x).'.'.$extention;
              if(copy('../../img/products/'.$value, '../../img/products/'.$fileName)){
                array_push($new_arr, $fileName);
              }
              $x++;
            }
            if($ProdOBJ->updateProduct('p_images',$ProdOBJ->lastinsert(),array(
              'img_arr' => json_encode($new_arr)
            ))!=TRUE){
              echo 'NO';
              exit();
            }
            echo 'OK';
            exit();
          }else{
            echo 'NO';
            exit();
          }
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('deleteThisimgkey')){
            $pid=htmlspecialchars(Input::get('deleteThisimgpid'));
            $img=htmlspecialchars(Input::get('deleteThisimgvalue'));
            $key=htmlspecialchars(Input::get('deleteThisimgkey'));
            $img_arr=json_decode($ProdOBJ->getProdukt('p_images', $pid)->img_arr);
            if(unlink('../../img/products/'.$img)){
              $new_arr=array();
              foreach ($img_arr as $akey => $value) {
                  if($img!=$value){
                  array_push($new_arr,$value);
                  }


              }
                if($ProdOBJ->updateProduct('p_images',$pid,array(
                  'img_arr' => json_encode($new_arr)
                ))!=TRUE){
                  echo 'NO';
                  exit();
                }
                echo 'OK';
                exit();

            }
            echo 'NO';
            exit();
        }/*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('saveEigenschaftonEDITpid')){
            $pid=htmlspecialchars(Input::get('saveEigenschaftonEDITpid'));
            $inp=htmlspecialchars(Input::get('saveEigenschaftonEDITinp'));
            if(trim($inp)){
                  $inp=explode(':', $inp);
                  if(trim($inp[1])){
                        $secarr=explode(',', $inp[1]);
                        $sarr=array();
                        foreach($secarr as $value){
                          if(!empty(trim($value))){
                              array_push($sarr, $value);
                          }
                        }
                        $existingEig_arr=$ProdOBJ->getProdukt('product',$pid)->eigenschaften;
                        $eigenName=$inp[0];
                        $eigenEarr=$sarr;
                        $objkey='';
                        $existcounter=0;
                        if($existingEig_arr=='a'){
                            //No element exists
                            $fullarr=array();
                            $innerarr=array($eigenName => $eigenEarr);
                            array_push($fullarr,$innerarr);
                            $finalarr=$fullarr;
                        }else{
                            //Array is set
                            $decodoldarr=json_decode($existingEig_arr);
                            $oldarrcount=count($decodoldarr);
                            for($i=0; $i < $oldarrcount; $i++){
                              if(array_key_exists($eigenName, $decodoldarr[$i])){
                                $objkey=$i;
                                $existcounter++;
                              }
                            }
                            if($existcounter > 0){
                              //change
                              $decodoldarr[$objkey]->$eigenName=$eigenEarr;
                              $finalarr=$decodoldarr;
                            }else{
                              //addtoexisting Array
                              $nearr=array($eigenName => $eigenEarr);
                              array_push($decodoldarr,$nearr);
                              $finalarr=$decodoldarr;
                            }

                        }


                        if($ProdOBJ->updateProduct('product',$pid,$arr=array(
                          'eigenschaften' => json_encode($finalarr)
                        ))!=TRUE){
                          echo 'NO';
                          exit();
                        }
                        print'OK';
                        exit();
                  }else{
                    print'OK';
                    exit();
                  }
            }else{
              print'OK';
              exit();
            }
        }

        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('deleteEigenschaftfullpid')){
            $pid=htmlspecialchars(Input::get('deleteEigenschaftfullpid'));
            $inp=htmlspecialchars(Input::get('deleteEigenschaftfullinp'));
            if(trim($inp)){
                $inp=explode(':', $inp);

                $EIGarr=json_decode($ProdOBJ->getProdukt('product',$pid)->eigenschaften);
                $maxcount=count($EIGarr);
                $arrkey='';
                $isThere=false;
                $newstr='[';
                for($i=0;$i<$maxcount;$i++){
                  foreach ($EIGarr[$i] as $key => $value) {
                    if($key==$inp[0]){
                        $arrkey=$i;
                        $isThere=true;
                    }else{
                        if($i>0){
                          $newstr.=',{"'.htmlspecialchars($key).'":';
                        }else{
                          $newstr.='{"'.htmlspecialchars($key).'":';
                        }
                        if(count($value>0)){
                          $newstr.='[';
                          foreach ($value as $nb=>$b) {
                            if($nb==count($value)-1){
                              $newstr.='"'.$b.'"';
                            }else{
                              $newstr.='"'.$b.'",';
                            }
                          }
                          $newstr.=']';
                        }

                            $newstr.='}';


                    }
                  }
                }
                $newstr.=']';
                if($newstr=='[]'){
                  $newstr='a';
                }
                //[{"Farbe":["blau","lila","gr\u00fcn","rosa"]},{"Gr\u00f6\u00dfe":["XL","L","M","S","XS"]}]
                if($isThere==true){
                  unset($EIGarr[$arrkey]);
                  if($ProdOBJ->updateProduct('product',$pid,array(
                    'eigenschaften' => $newstr
                  ))!=TRUE){
                    echo 'NO';
                    exit();
                  }
                  echo 'OK';
                  exit();
                }
            }else{
              echo 'OK';
              exit();
            }

        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('madeitGalleryvalue')){
            $pid=htmlspecialchars(Input::get('madeitGallerypid'));
            $img=htmlspecialchars(Input::get('madeitGalleryvalue'));
            $img_arr=json_decode($ProdOBJ->getProdukt('p_images', $pid)->img_arr);
            $newkey='';
              foreach ($img_arr as $akey => $value) {
                  if($img==$value){
                  $newkey=$akey;
                  }
              }
                if($ProdOBJ->updateProduct('p_images',$pid,array(
                  'front_img' => $newkey
                ))!=TRUE){
                  echo 'NO';
                  exit();
                }
                echo 'OK';
                exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('deleteProducttpid')){
            $pid=htmlspecialchars(Input::get('deleteProducttpid'));
            $img_arr=json_decode($ProdOBJ->getProdukt('p_images', $pid)->img_arr);
            foreach($img_arr as $value){
              if(file_exists("../../img/products/".$value)){
              unlink("../../img/products/".$value);
              }
            }
            
            if($ProdOBJ->deleteProduct('p_images',$pid)!=FALSE){
              if($ProdOBJ->deleteProduct('product',$pid)!=FALSE){
                print'OK';
                exit();
              }
            }
            print'NO';
            exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('toogleONOFFpid')){
            $pid=htmlspecialchars(Input::get('toogleONOFFpid'));
            if($ProdOBJ->getProdukt('product',$pid)->p_stat==0){
              $tr='1';
            }else{
              $tr='0';
            }
                if($ProdOBJ->updateProduct('product',$pid,array(
                  'p_stat' => $tr
                ))!=TRUE){
                  echo 'NO';
                  exit();
                }
                echo 'OK_'.$tr;
                exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('checkinPtypvalue')){
            $pid=htmlspecialchars(Input::get('checkinPtyppid'));
            $inp=htmlspecialchars(Input::get('checkinPtypvalue'));
            if($inp==1){
              $arr=array(
                'p_type' => $inp
              );
            }else{
              $arr=array(
                'p_type' => $inp,
                'o_type' => '1'
              );
            }
                if($ProdOBJ->updateProduct('product',$pid,$arr)!=TRUE){
                  echo 'NO';
                  exit();
                }
                if($inp==1){
                  if($ProdOBJ->getProdukt('product',$pid)->o_type==1){
                    echo '<option value="1" selected="selected">Festpreis</option><option value="2">Auktion</option>_
                    <div class="fieldset">
                    <label>Produkt Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktPreis" id="ProduktPreis" value="'.$ProdOBJ->getProdukt('product',$pid)->price.'" placeholder="Geben Sie den Produkt-Preis an..." />
                    </div>
                    <div class="fieldset">
                    <label>Produkt UVP-Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktUVP-Preis" id="ProduktUVP-Preis" value="'.$ProdOBJ->getProdukt('product',$pid)->newprice.'" placeholder="Geben Sie den UVP-Preis an..." />
                    </div>
                    <div class="fieldset">
                    <label>Produkt Rabatt-Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktRabatt-Preis" id="ProduktRabatt-Preis" value="'.$ProdOBJ->getProdukt('product',$pid)->rabattprice.'" placeholder="Geben Sie den Rabatt-Preis an..." />
                    </div>';
                    exit();
                  }else{
                    switch ($ProdOBJ->getProdukt('product',$pid)->auction_time) {
                      case 5:
                      $optsAuktTime='<option selected="selected" value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                      break;
                      case 10:
                      $optsAuktTime='<option value="5">5 Tage</option><option selected="selected" value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                      break;
                      case 15:
                      $optsAuktTime='<option value="5">5 Tage</option><option value="10">10 Tage</option><option selected="selected" value="15">15 Tage</option><option value="30">30 Tage</option>';
                      break;
                      case 30:
                      $optsAuktTime='<option value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option selected="selected" value="30">30 Tage</option>';
                      break;
                      default:
                      $optsAuktTime='<option selected="selected" value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                      break;
                    }
                    echo '<option value="1">Festpreis</option><option selected="selected" value="2">Auktion</option>_
                    <div class="fieldset">
                    <label>Auktions Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktPreis" id="ProduktPreis" value="'.$ProdOBJ->getProdukt('product',$pid)->price.'" placeholder="Geben Sie den Auktions-Preis an..." />
                    </div>
                    <div class="fieldset">
                    <label>Sofortkauf Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="Sofortkauf" id="Sofortkauf" value="'.$ProdOBJ->getProdukt('product',$pid)->dpreis.'" placeholder="Geben Sie den Sofortkauf-Preis an..." />
                    </div>
                    <div class="fieldset">
                    <label>Auktions Zeitraum</label>
                        <select onchange="SaveStrTarget(\''.$pid.'\')" name="AuktionsZeitraum" id="AuktionsZeitraum">
                        '.$optsAuktTime.'
                        </select>
                    </div>';
                    exit();
                  }
                }else{
                  echo '<option value="1" selected="selected">Festpreis</option>_
                  <div class="fieldset">
                  <label>Produkt Preis</label>
                      <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktPreis" id="ProduktPreis" value="'.$ProdOBJ->getProdukt('product',$pid)->price.'" placeholder="Geben Sie den Produkt-Preis an..." />
                  </div>
                  <div class="fieldset">
                  <label>Produkt UVP-Preis</label>
                      <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktUVP-Preis" id="ProduktUVP-Preis" value="'.$ProdOBJ->getProdukt('product',$pid)->newprice.'" placeholder="Geben Sie den UVP-Preis an..." />
                  </div>
                  <div class="fieldset">
                  <label>Produkt Rabatt-Preis</label>
                      <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktRabatt-Preis" id="ProduktRabatt-Preis" value="'.$ProdOBJ->getProdukt('product',$pid)->rabattprice.'" placeholder="Geben Sie den Rabatt-Preis an..." />
                  </div>';
                  exit();
                }

        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('checkinPFORMATvalue')){
            $pid=htmlspecialchars(Input::get('checkinPFORMATpid'));
            $inp=htmlspecialchars(Input::get('checkinPFORMATvalue'));

                if($ProdOBJ->updateProduct('product',$pid,$arr=array(
                  'o_type' => $inp
                ))!=TRUE){
                  echo 'NO';
                  exit();
                }

                  if($inp==1){
                    echo '
                    <div class="fieldset">
                    <label>Produkt Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktPreis" id="ProduktPreis" value="'.$ProdOBJ->getProdukt('product',$pid)->price.'" placeholder="Geben Sie den Produkt-Preis an..." />
                    </div>
                    <div class="fieldset">
                    <label>Produkt UVP-Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktUVP-Preis" id="ProduktUVP-Preis" value="'.$ProdOBJ->getProdukt('product',$pid)->newprice.'" placeholder="Geben Sie den UVP-Preis an..." />
                    </div>
                    <div class="fieldset">
                    <label>Produkt Rabatt-Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktRabatt-Preis" id="ProduktRabatt-Preis" value="'.$ProdOBJ->getProdukt('product',$pid)->rabattprice.'" placeholder="Geben Sie den Rabatt-Preis an..." />
                    </div>';
                    exit();
                  }else{
                    switch ($ProdOBJ->getProdukt('product',$pid)->auction_time) {
                      case 5:
                      $optsAuktTime='<option selected="selected" value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                      break;
                      case 10:
                      $optsAuktTime='<option value="5">5 Tage</option><option selected="selected" value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                      break;
                      case 15:
                      $optsAuktTime='<option value="5">5 Tage</option><option value="10">10 Tage</option><option selected="selected" value="15">15 Tage</option><option value="30">30 Tage</option>';
                      break;
                      case 30:
                      $optsAuktTime='<option value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option selected="selected" value="30">30 Tage</option>';
                      break;
                      default:
                      $optsAuktTime='<option selected="selected" value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                      break;
                    }
                    echo '
                    <div class="fieldset">
                    <label>Auktions Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="ProduktPreis" id="ProduktPreis" value="'.$ProdOBJ->getProdukt('product',$pid)->price.'" placeholder="Geben Sie den Auktions-Preis an..." />
                    </div>
                    <div class="fieldset">
                    <label>Sofortkauf Preis</label>
                        <input type="text" onblur="SaveStrTarget(\''.$pid.'\')" name="Sofortkauf" id="Sofortkauf" value="'.$ProdOBJ->getProdukt('product',$pid)->dpreis.'" placeholder="Geben Sie den Sofortkauf-Preis an..." />
                    </div>
                    <div class="fieldset">
                    <label>Auktions Zeitraum</label>
                        <select onchange="SaveStrTarget(\''.$pid.'\')" name="AuktionsZeitraum" id="AuktionsZeitraum">
                        '.$optsAuktTime.'
                        </select>
                    </div>';
                    exit();
                  }


        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('SaveStrTargettyp')){

            $pid=htmlspecialchars(Input::get('SaveStrTargetpid'));
            $typ=htmlspecialchars(Input::get('SaveStrTargettyp'));
            $val=htmlspecialchars(Input::get('SaveStrTargetvalue'));

            switch($typ){
              case 'pname':
              $typ=array(
                'name' => $val
              );
              break;
              case 'Produkt-Beschreibung':
              $typ=array(
                'describing' => $val
              );
              break;
              case 'Produkt-Tags':
              $typ=array(
                'p_tagwort' => $val
              );
              break;
              case 'Lagerbestand':
              $typ=array(
                'p_quant' => $val
              );
              break;
              case 'Besteuert':
              $typ=array(
                'tax_type' => $val
              );
              break;
              case 'Gewicht':
              $typ=array(
                'p_weight' => $val
              );
              break;
              case 'PacketBreite':
              $typ=array(
                'p_width' => $val
              );
              break;
              case 'PacketLong':
              $typ=array(
                'p_height' => $val
              );
              break;
              case 'PacketTiefe':
              $typ=array(
                'p_deep' => $val
              );
              break;
              case 'ProduktPreis':
              $typ=array(
                'price' => $val
              );
              break;
              case 'ProduktUVP-Preis':
              $typ=array(
                'newprice' => $val
              );
              break;
              case 'ProduktRabatt-Preis':
              $typ=array(
                'rabattprice' => $val
              );
              break;
              case 'Sofortkauf':
              $typ=array(
                'dpreis' => $val,
                'dbuy' => '1'
              );
              break;
              case 'AuktionsZeitraum':
              $typ=array(
                'auction_time' => $val
              );
              break;
            }

                if($ProdOBJ->updateProduct('product',$pid,$typ)!=TRUE){
                  echo 'NO';
                  exit();
                }
                echo 'OK';
                exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('changeProductSettings')){
          $listing='';
          $addeditImg='';
          $gallery='';

              foreach(json_decode($ProdOBJ->getProdukt('p_images', htmlspecialchars(Input::get('changeProductSettings')))->img_arr) as $key => $value){
                if($key==$ProdOBJ->getProdukt('p_images',htmlspecialchars(Input::get('changeProductSettings')))->front_img){
                  $gallery=$value;
                  $listing.='<img src="img/products/'.$value.'" class="choosegallery" id="bimg'.$key.'" onclick="setintext(\''.$value.'\')" />';
                  $addeditImg.='<div class="choosegallery" id="img'.$key.'"><img src="img/products/'.$value.'" onclick="madeitGallery(\''.$value.'\',\''.Input::get('changeProductSettings').'\')" style="margin:0;display:inline-block;float:left;width:100%;"/><div onclick="deleteThisimg(\''.$key.'\',\''.$value.'\',\''.Input::get('changeProductSettings').'\')" class="closerImg">X</div></div>';
                }else{
                  $listing.='<img src="img/products/'.$value.'" class="choosegallery" id="bimg'.$key.'" onclick="setintext(\''.$value.'\')" />';
                  $addeditImg.='<div class="choosegallery" id="img'.$key.'"><img src="img/products/'.$value.'" onclick="madeitGallery(\''.$value.'\',\''.Input::get('changeProductSettings').'\')" style="margin:0;display:inline-block;float:left;width:100%;"/><div onclick="deleteThisimg(\''.$key.'\',\''.$value.'\',\''.Input::get('changeProductSettings').'\')" class="closerImg">X</div></div>';
                }
              }
              $addeditImg.='<div class="choosegallery" id="addmoreIMGDIV" style="text-align:center;"><div style="display:inline-block;font-size:4em;">+</div><div id="wrapper" style="display:none;"><form enctype="multipart/form-data" method="post"><input type="file" onchange="addtootherimages(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" id="addmoreIMG" name="addmoreIMG" multiple /></form></div></div>
              <script>var imgbtn=document.getElementById("addmoreIMGDIV");
              var imginputfile=document.getElementById("addmoreIMG");
              imgbtn.addEventListener("click",function(){
                imginputfile.click();
              });
              function completeHandlerPIMG(event) {
                $(function(){

                  if(event.target.responseText=="NO"){

                  }else{
                    changeProductSettings(event.target.responseText);
                  }
                });
              }
              function addtootherimages(id) {
              var file = document.getElementById("addmoreIMG").files;
              if(file.length>0){
              // alert(file.name+" | "+file.size+" | "+file.type);
              var formdata = new FormData();

              for(var i = 0; i < file.length; i++){
                formdata.append("file"+i, file[i]);
              }

              formdata.append("addmoreIMGpid", id);
              var ajax = new XMLHttpRequest();
              ajax.addEventListener("load", completeHandlerPIMG, false);
              ajax.open("POST", "includes/php/admin_product.php");
              ajax.send(formdata);
              }else{

              }
              }
              </script>';
              if($ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->tax_type==1){
                $optstax='<option value="1" selected="selected">Besteuert MwSt</option><option value="2">Nicht Besteuern</option>';
              }else{
                $optstax='<option value="1">Besteuert MwSt</option><option selected="selected" value="2">Nicht Besteuern</option>';
              }
              if($ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->p_type==1){
                $Variantenbtn='';
                $optsPtyp='<option value="1" selected="selected">Einfaches Produkt</option><option value="2">Variables Produkt</option>';
                if($ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->o_type==1){
                  $optsPFormat='<option value="1" selected="selected">Festpreis</option><option value="2">Auktion</option>';
                  $optsPFormINp='<div class="fieldset">
                  <label>Produkt Preis</label>
                      <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="ProduktPreis" id="ProduktPreis" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->price.'" placeholder="Geben Sie den Produkt-Preis an..." />
                  </div>
                  <div class="fieldset">
                  <label>Produkt UVP-Preis</label>
                      <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="ProduktUVP-Preis" id="ProduktUVP-Preis" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->newprice.'" placeholder="Geben Sie den UVP-Preis an..." />
                  </div>
                  <div class="fieldset">
                  <label>Produkt Rabatt-Preis</label>
                      <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="ProduktRabatt-Preis" id="ProduktRabatt-Preis" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->rabattprice.'" placeholder="Geben Sie  den Rabatt-Preis an..." />
                  </div>';
                }else{
                  $optsPFormat='<option value="1">Festpreis</option><option selected="selected" value="1">Auktion</option>';
                  switch ($ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->auction_time) {
                    case 5:
                    $optsAuktTime='<option selected="selected" value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                    break;
                    case 10:
                    $optsAuktTime='<option value="5">5 Tage</option><option selected="selected" value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                    break;
                    case 15:
                    $optsAuktTime='<option value="5">5 Tage</option><option value="10">10 Tage</option><option selected="selected" value="15">15 Tage</option><option value="30">30 Tage</option>';
                    break;
                    case 30:
                    $optsAuktTime='<option value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option selected="selected" value="30">30 Tage</option>';
                    break;
                    default:
                    $optsAuktTime='<option selected="selected" value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option>';
                    break;
                  }
                  $optsPFormINp='<div class="fieldset">
                  <label>Auktions Preis</label>
                      <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="ProduktPreis" id="ProduktPreis" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->price.'" placeholder="Geben Sie den Auktions-Preis an..." />
                  </div>
                  <div class="fieldset">
                  <label>Sofortkauf Preis</label>
                      <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="Sofortkauf" id="Sofortkauf" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->dpreis.'" placeholder="Geben Sie den SofortKauf-Preis an..." />
                  </div>
                  <div class="fieldset">
                  <label>Auktions Zeitraum</label>
                      <select onchange="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="AuktionsZeitraum" id="AuktionsZeitraum">
                      '.$optsAuktTime.'
                      </select>
                  </div>';
                }
              }else{
                $Variantenbtn='<div class="branding-name">Varianten bearbeiten</div><div class="fieldset"><div class="btn-int-admin" onclick="aktualVariants(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')">Varianten aktualisieren</div></div>';
                $optsPtyp='<option value="1">Einfaches Produkt</option><option selected="selected" value="2">Variables Produkt</option>';
                $optsPFormat='<option value="1" selected="selected">Festpreis</option>';
                $optsPFormINp='<div class="fieldset">
                <label>Produkt Preis</label>
                    <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="ProduktPreis" id="ProduktPreis" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->price.'" placeholder="Geben Sie den Produkt-Preis an..." />
                </div>
                <div class="fieldset">
                <label>Produkt UVP-Preis</label>
                    <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="ProduktUVP-Preis" id="ProduktUVP-Preis" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->newprice.'" placeholder="Geben Sie den UVP-Preis an..." />
                </div>
                <div class="fieldset">
                <label>Produkt Rabatt-Preis</label>
                    <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="ProduktRabatt-Preis" id="ProduktRabatt-Preis" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->rabattprice.'" placeholder="Geben Sie  den Rabatt-Preis an..." />
                </div>';
              }

              $optEigenschaften='';
              foreach($ProdOBJ->getEigenschaften() as $value){
                $optEigenschaften.='<option value="'.$value->name.'">'.$value->name.'</option>';
              }
              $showsavedEigen='';
              $xx=0;
              $EIGarr=json_decode($ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->eigenschaften);
              $maxcount=count($EIGarr);
              if($maxcount>0){
                  for($i=0;$i<$maxcount;$i++){
                        foreach($EIGarr[$i] as $skey=>$value){
                        //$showsavedEigen.=$skey.'<br>';
                              $bstring='';
                              $incount=count($value);
                              foreach($value as $key=>$sval){
                                if($key==$incount-1){
                                  $bstring.=$sval;
                                }else{
                                  $bstring.=$sval.',';
                                }
                              }
                              $showsavedEigen.='<div id="branking'.$xx.'" class="branding-name">Eigenschaft festlegen<i onclick="deleteEigenschaftfull(\''.htmlspecialchars(Input::get('changeProductSettings')).'\',\''.$xx.'\')" class="fas fa-trash-alt" style="cursor:pointer;float:right;padding:0.4em;"></i></div><p id="brankingp'.$xx.'">Hier können Sie die Eigenschaft des Produktes festlegen. Benutzen Sie dafür folgende Syntax (NameEigenschaft:Variante,Variante,...)</p><div id="brankingf'.$xx.'" class="fieldset"><input value="'.$skey.':'.$bstring.'" type="text" onblur="saveEigenschaftonEDIT(\''.htmlspecialchars(Input::get('changeProductSettings')).'\',\''.$xx.'\')" name="peigenschaft'.$xx.'" id="peigenschaft'.$xx.'" placeholder="NameEigenschaft:Variante,Variante,..." /></div>';
                        }



                    $xx++;
                  }
              }
          echo'
          <div class="flexi-show">
            <h3><i class="fas fa-edit"></i> Produkt bearbeiten</h3><hr>
            <div class="branding-name">Produktbilder bearbeiten</div>
            <div class="fieldset">
            <label>Gallerie-Bild</label>
            <div class="fieldset">
            <div id="divprevGalleryIMG" style="border:2px solid #FFFFFF;width:6em;height:8em;background-image:url(\'img/products/'.$gallery.'\');background-size:100% 100%;background-position:center; background-repeat:none;"></div>
            </div>
            </div>
            <div class="fieldset">
            <label>Medien</label>
            '.$addeditImg.'
            </div>
            <div class="branding-name">Produkt-Info bearbeiten</div>
            <div class="fieldset">
            <label>Produkt-Titel</label>
                <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="pname" id="pname" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->name.'" placeholder="Geben Sie einen Produkt-Titel an..." />
            </div>
            <div class="fieldset">
            <label>Produkt-Beschreibung</label>
            <p>Sie können in der Beschreibung Bilder Hinzufügen aus der Gallerie.</p>
            <div class="fieldset">
            '.$listing.'
            </div>
            <div class="fieldset">
            <textarea id="Produkt-Beschreibung" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" placeholder="Beschreiben Sie Ihr Produkt">'.htmlspecialchars_decode($ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->describing).'</textarea>
            </div>
            <div class="fieldset" id="TextVorschautab">
            </div>
            <div class="fieldset"><div class="btn-int-admin" onclick="TextVorschauBeschreibung()">Vorschau</div></div>
            </div>
            <div class="fieldset">
            <label>Tag-Wörter</label>
            <p>Hier können Sie die Tag-Wörter bearbeiten.</p>
            <div class="fieldset">
            <textarea id="Produkt-Tags" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" placeholder="Beschreiben Sie Ihr Produkt">'.htmlspecialchars_decode($ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->p_tagwort).'</textarea>
            </div>
            <div class="fieldset">
            <label>Lagerbestand</label>
                <input type="number" min="0" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="Lagerbestand" id="Lagerbestand" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->p_quant.'" placeholder="Geben Sie den Lagerbestand an..." />
            </div>
            <div class="fieldset">
            <label>Steuer</label>
                <select onchange="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="Besteuert" id="Besteuert">
                '.$optstax.'
                </select>
            </div>
            <div class="fieldset">
            <label>Gewicht Format 1,000 (Kg)</label>
                <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="Gewicht" id="Gewicht" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->p_weight.'" placeholder="Geben Sie das Produkt-Gewicht an..." />
            </div>
            <div class="fieldset">
            <label>Paket Breite (cm)</label>
                <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="PacketBreite" id="PacketBreite" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->p_width.'" placeholder="Geben Sie die Paket-Breite an..." />
            </div>
            <div class="fieldset">
            <label>Paket Länge (cm)</label>
                <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="PacketLong" id="PacketLong" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->p_height.'" placeholder="Geben Sie die Paket-Länge an..." />
            </div>
            <div class="fieldset">
            <label>Paket Tiefe (cm)</label>
                <input type="text" onblur="SaveStrTarget(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="PacketTiefe" id="PacketTiefe" value="'.$ProdOBJ->getProdukt('product',htmlspecialchars(Input::get('changeProductSettings')))->p_deep.'" placeholder="Geben Sie die Paket-Tiefe an..." />
            </div>
            </div>
            <div class="branding-name">Produkt-Preis bearbeiten</div>
            <div class="fieldset">
            <label>Produkt-Typ</label>
                <select onchange="checkinPtyp(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="Produkt-Typ" id="Produkt-Typ">
                '.$optsPtyp.'
                </select>
            </div>
            <div class="fieldset">
            <label>Preis-Format</label>
            <select onchange="checkinPFORMAT(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" name="Preis-Format" id="Preis-Format">
            '.$optsPFormat.'
            </select>
            </div>
            <div id="div-FormatPINPS">
            '.$optsPFormINp.'
            </div>
            <div class="branding-name">Varianten und Eigenschaften</div>
            <p>Legen Sie Die Eigenschaften Ihres Produktes fest. Wenn der Kunde Möglichkeit der Auswahl haben sollte, dann können Sie diese hier festlegen.</p>
            <div class="branding-name">Produkt-Eigenschaften</div>
            <div class="fieldset">
            <input type="hidden" value="'.$xx.'" id="EcounterE" />
            <select onchange="addEigenschaft(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')" id="seltypeigenschaft"><option value="n">Benutzerdefiniert</option>'.$optEigenschaften.'</select>
            <div class="fieldset"><div class="btn-int-admin" onclick="addEigenschaft(\''.htmlspecialchars(Input::get('changeProductSettings')).'\')">Hinzufügen</div></div>
            </div>
            <div class="fieldset" id="Eigenschaftenvorschautab">
            '.$showsavedEigen.'
            </div>
            <div class="fieldset" id="Variantenschautabbtn">
            '.$Variantenbtn.'
            </div>
            <div class="fieldset" id="Variantenschautab">

            </div>
          </div>
          ';
          exit();
        }

        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('TKats')){
          Session::put('wTKat', Input::get('TKats'));
          $list='<div class="existing-check-rows" >';
          foreach(Input::get('TKats') as $value){
            foreach(json_decode($CatOBJ->getKat($value)->und_kat) as $b){
              $list.='<div class="existing-checkboxes"><input type="checkbox" class="checkboxInp" value="'.$b.'" name="UndKats[]" /> '.$b.'</div>';
            }
          }
          $list.='</div><div class="fieldset"><div class="btn-int-admin" onclick="saveStepTwo()">Speichern und weiter >></div></div>';
          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Bitte wählen Sie die Unter-Kategorien aus.</p>
            <div class="branding-name">Unter-Kategorien auswählen</div>
            '.$list.'
          </div>
          ';
          echo $ausgabe;
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('UKats')){
          Session::put('wUKat', Input::get('UKats'));

          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Bitte geben Sie den Namen des Produktes an.</p>
            <div class="branding-name">Name des Produktes</div>
            <div class="fieldset">
                <input type="text" name="pname" id="pname" placeholder="Geben Sie einen Produkt-Titel an..." />
            </div>
            <p>Bitte wählen Sie aus, ob es sich um ein einfaches Produkt oder ein variables Produkt handelt.</p>
            <div class="branding-name">Produkt-Typ</div>
            <div id="PFormat-div" class="fieldset">
                <select id="PFormat" onchange="getPriceForm()"><option>Auswählen</option><option value="1">Einfaches Produkt</option><option value="2">Variables Produkt</option></select>
            </div>
            <div id="div-PreisFormat" style="display:none;">
              <p id="p-PreisFormat"></p>
              <div class="branding-name">Preis-Format</div><div class="fieldset">
              <select id="PreisFormat" onchange="getPForm()"></select>
              </div>
            </div>
            <div id="div-Preis">

            </div>
          </div>
          ';
          echo $ausgabe;
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('pname')&&(Input::get('pformat'))&&(Input::get('preisformat'))){


          if(Input::get('pformat')=='1'){
              //Einfaches Produkt
              if(Input::get('preisformat')=='1'){
                if(!Input::get('uvppreis')){
                  $uvppreis=0;
                }else{
                  $uvppreis=htmlspecialchars(Input::get('uvppreis'));
                }
                if(!Input::get('angebotpreis')){
                  $rabattpreis=0;
                }else{
                  $rabattpreis=htmlspecialchars(Input::get('angebotpreis'));
                }
                if(!Input::get('preis')){
                  $preis=0;
                }else{
                  $preis=htmlspecialchars(Input::get('preis'));
                }
                    //Festpreis
                    if($ProdOBJ->createProduct('product',array(
                      'kat_id' => json_encode(Session::get('wTKat')),
                      'undKat_id' => json_encode(Session::get('wUKat')),
                      'name' => htmlspecialchars(Input::get('pname')),
                      'p_type' => htmlspecialchars(Input::get('pformat')),
                      'o_type' => htmlspecialchars(Input::get('preisformat')),
                      'price' => $preis,
                      'newprice' => $uvppreis,
                      'rabattprice' => $rabattpreis,
                      'created_time' => time()
                    ))!=TRUE){
                      $ausgabe='NO';
                    } $button=$ProdOBJ->lastinsert();

              }else{

                    //Auktion
                    if(!trim(Input::get('direktpreis'))){
                      $dbuy=0;
                    }else {
                      $dbuy=1;
                    }
                    if(!Input::get('uvppreis')){
                      $uvppreis=0;
                    }else{
                      $uvppreis=htmlspecialchars(Input::get('uvppreis'));
                    }
                    if(!Input::get('angebotpreis')){
                      $rabattpreis=0;
                    }else{
                      $rabattpreis=htmlspecialchars(Input::get('angebotpreis'));
                    }
                    if(!Input::get('preis')){
                      $preis=0;
                    }else{
                      $preis=htmlspecialchars(Input::get('preis'));
                    }
                    if($ProdOBJ->createProduct('product',array(
                      'kat_id' => json_encode(Session::get('wTKat')),
                      'undKat_id' => json_encode(Session::get('wUKat')),
                      'name' => htmlspecialchars(Input::get('pname')),
                      'p_type' => htmlspecialchars(Input::get('pformat')),
                      'o_type' => htmlspecialchars(Input::get('preisformat')),
                      'price' => $preis,
                      'dbuy' => $dbuy,
                      'dpreis' => htmlspecialchars(Input::get('direktpreis')),
                      'auction_time' => htmlspecialchars(Input::get('auctime')),
                      'newprice' => $uvppreis,
                      'rabattprice' => $rabattpreis,
                      'created_time' => time()
                    ))!=TRUE){
                      $ausgabe='NO';
                    } $button=$ProdOBJ->lastinsert();

              }

          }else{
            if(!Input::get('uvppreis')){
              $uvppreis=0;
            }else{
              $uvppreis=htmlspecialchars(Input::get('uvppreis'));
            }
            if(!Input::get('angebotpreis')){
              $rabattpreis=0;
            }else{
              $rabattpreis=htmlspecialchars(Input::get('angebotpreis'));
            }
            if(!Input::get('preis')){
              $preis=0;
            }else{
              $preis=htmlspecialchars(Input::get('preis'));
            }
              //Variables Produkt
              if($ProdOBJ->createProduct('product',array(
                'kat_id' => json_encode(Session::get('wTKat')),
                'undKat_id' => json_encode(Session::get('wUKat')),
                'name' => htmlspecialchars(Input::get('pname')),
                'p_type' => htmlspecialchars(Input::get('pformat')),
                'o_type' => htmlspecialchars(Input::get('preisformat')),
                'price' => $preis,
                'newprice' => $uvppreis,
                'rabattprice' => $rabattpreis,
                'created_time' => time()
              ))!=TRUE){
                $ausgabe='NO';
              } $button=$ProdOBJ->lastinsert();

          }

          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Wählen Sie alle Fotos des Produktes aus und laden diese hoch. Im nächsten Schritt können Sie das Gallerie-Bild festlegen.</p>
            <div class="branding-name">Produkt-Bilder hinzufügen</div>
            <div class="fieldset">
              <form enctype="multipart/form-data" method="post">
                <input type="file" name="files" id="files" multiple />
              </form>
                <progress id="progressBar" value="0" max="100"></progress><br>
                <span id="filemsg"></span>

            </div>
            <div class="fieldset"><div class="btn-int-admin" onclick="saveStepPFour(\''.$button.'\')">Hochladen und weiter >></div></div>
          </div>
          ';
          print($ausgabe);
          exit();

        }
        /*
        Ausgabe des HTML NEW PRODUKT 1 choosegallerypic
        */
        if(Input::get('choosegallerypic')){
          Session::put('wpid', Input::get('choosegallerypic'));
          $listing='';
              foreach(json_decode($ProdOBJ->getProdukt('p_images', htmlspecialchars(Input::get('choosegallerypic')))->img_arr) as $key => $value){
                if($key==$ProdOBJ->getProdukt('p_images',htmlspecialchars(Input::get('choosegallerypic')))->front_img){
                  $listing.='<img src="img/products/'.$value.'" class="choosegallery" style="border:0.4em solid #00FF00;" onclick="setAsGallery(\''.$key.'\')" />';
                }else{
                  $listing.='<img src="img/products/'.$value.'" class="choosegallery" onclick="setAsGallery(\''.$key.'\')" />';
                }
              }
          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Legen Sie das Gallerie-Bild festlegen für den Produkt-Katalog.</p>
            <div class="branding-name">Gallerie-Bild festlegen</div>
            <div class="fieldset" id="choosegalleryImgkey">
            '.$listing.'
            </div>
            <div class="fieldset"><div class="btn-int-admin" onclick="letsdescripProduct()">Speichern und weiter >></div></div>
          </div>
          ';

          print($ausgabe);
          exit();

        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('letsdescripProduct')){
          $listing='';
              foreach(json_decode($ProdOBJ->getProdukt('p_images', htmlspecialchars(Session::get('wpid')))->img_arr) as $key => $value){
                if($key==$ProdOBJ->getProdukt('p_images',htmlspecialchars(Session::get('wpid')))->front_img){
                  $listing.='<img src="img/products/'.$value.'" class="choosegallery" onclick="setintext(\''.$value.'\')" />';
                }else{
                  $listing.='<img src="img/products/'.$value.'" class="choosegallery" onclick="setintext(\''.$value.'\')" />';
                }
              }
          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Legen Sie Die Beschreibung für Ihr Produkt fest.</p>
            <div class="branding-name">Produkt-Beschreibung</div>
            <p>Sie können in der Beschreibung Bilder Hinzufügen aus der Gallerie.</p>
            <div class="fieldset">
            '.$listing.'
            </div>
            <div class="fieldset">
            <textarea id="Produkt-Beschreibung" placeholder="Beschreiben Sie Ihr Produkt"></textarea>
            </div>
            <div class="fieldset" id="TextVorschautab">
            </div>
            <div class="fieldset"><div class="btn-int-admin" onclick="TextVorschauBeschreibung()">Vorschau</div></div>
            <div class="fieldset"><div class="btn-int-admin" onclick="ProduktEigenschaften()">Speichern und weiter >></div></div>
          </div>
          ';

          print($ausgabe);
          exit();

        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('addEigenschaftvalue')){
          $t=htmlspecialchars(Input::get('addEigenschaftvalue'));
          $pid=htmlspecialchars(Input::get('addEigenschaftpid'));
          $counter=htmlspecialchars(Input::get('addEigenschaftcount'));
          $existingEig_arr=$ProdOBJ->getProdukt('product',$pid)->eigenschaften;
          $eigenschaft=$ProdOBJ->getProdukt('p_eigenschaften', $t);
          $eigenName=$eigenschaft->name;
          $eigenEarr=json_decode($eigenschaft->e_arr);
          $objkey='';
          $existcounter=0;
          if($existingEig_arr=='a'){
              //No element exists
              $fullarr=array();
              $innerarr=array($eigenName => $eigenEarr);
              array_push($fullarr,$innerarr);
              $finalarr=$fullarr;
          }else{
              //Array is set
              $decodoldarr=json_decode($existingEig_arr);
              $oldarrcount=count($decodoldarr);
              for($i=0; $i < $oldarrcount; $i++){
                if(array_key_exists($eigenName, $decodoldarr[$i])){
                  $objkey=$i;
                  $existcounter++;
                }
              }
              if($existcounter > 0){
                //change
                $decodoldarr[$objkey]->$eigenName=$eigenEarr;
                $finalarr=$decodoldarr;
              }else{
                //addtoexisting Array
                $nearr=array($eigenName => $eigenEarr);
                array_push($decodoldarr,$nearr);
                $finalarr=$decodoldarr;
              }

          }
          $string='';
          $arrcount=count(json_decode($eigenschaft->e_arr));
          foreach (json_decode($eigenschaft->e_arr) as $key => $value) {
            if($key==$arrcount-1){
              $string.=$value;
            }else{
              $string.=$value.',';
            }
          }

          if($ProdOBJ->updateProduct('product',$pid,$arr=array(
            'eigenschaften' => json_encode($finalarr)
          ))!=TRUE){
            echo 'NO';
            exit();
          }
          $ausgabe='
          <div id="branking'.$counter.'" class="branding-name">Eigenschaft festlegen<i onclick="deleteEigenschaftfull(\''.$pid.'\',\''.$counter.'\')" class="fas fa-trash-alt" style="cursor:pointer;float:right;padding:0.4em;"></i></div><p id="brankingp'.$counter.'">Hier können Sie die Eigenschaft des Produktes festlegen.
          Benutzen Sie dafür folgende Syntax (NameEigenschaft:Variante,Variante,...)</p><div id="brankingf'.$counter.'" class="fieldset">
          <input onblur="saveEigenschaftonEDIT(\''.$pid.'\',\''.$counter.'\')" type="text" value="'.$eigenName.':'.$string.'" name="peigenschaft'.$counter.'" id="peigenschaft'.$counter.'" placeholder="NameEigenschaft:Variante,Variante,..." />
          </div>
          ';

          print($ausgabe);
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('addeigenschaftsel')){

          $eigenschaft=$ProdOBJ->getProdukt('p_eigenschaften', htmlspecialchars(Input::get('addeigenschaftsel')));
          $string=$eigenschaft->name.':';
          $arrcount=count(json_decode($eigenschaft->e_arr));
          foreach (json_decode($eigenschaft->e_arr) as $key => $value) {
            if($key==$arrcount-1){
              $string.=$value;
            }else{
              $string.=$value.',';
            }
          }
          $ausgabe='
          <div class="branding-name">Eigenschaft festlegen</div><p>Hier können Sie die Eigenschaft des Produktes festlegen.
          Benutzen Sie dafür folgende Syntax (NameEigenschaft:Variante,Variante,...)</p><div class="fieldset">
          <input type="text" value="'.$string.'" name="peigenschaft" id="peigenschaft" placeholder="NameEigenschaft:Variante,Variante,..." />
          </div>
          ';

          print($ausgabe);
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('tProduktEigenschaften')){
          if(!Input::get('tProduktEigenschaften')){
            $text='a';
          }else{
            $text=Input::get('tProduktEigenschaften');
          }
          if($ProdOBJ->updateProduct('product',htmlspecialchars(Session::get('wpid')),array('describing' => htmlspecialchars($text)))!=TRUE){
            print 'NO';
            exit();
          }
          $opt='';
          foreach($ProdOBJ->getEigenschaften() as $value){
            $opt.='<option value="'.$value->name.'">'.$value->name.'</option>';
          }

          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Legen Sie Die Eigenschaften Ihres Produktes fest. Wenn der Kunde Möglichkeit der Auswahl haben sollte, dann können Sie diese hier festlegen.</p>
            <div class="branding-name">Produkt-Eigenschaften</div>
            <div class="fieldset">
            <select onchange="addeigenschaftsel()" id="seltypeigenschaft"><option value="n">Benutzerdefiniert</option>'.$opt.'</select>
            <div class="fieldset"><div class="btn-int-admin" onclick="addeigenschaftsel()">Hinzufügen</div></div>
            </div>
            <div class="fieldset" id="Eigenschaftenvorschautab">
            </div>
            <div class="fieldset"><div class="btn-int-admin" onclick="savePEigenschaften()">Speichern und weiter >></div></div>
          </div>
          ';

          print($ausgabe);
          exit();
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('savePEigenschaften')){
          $b=count(Input::get('savePEigenschafteninps'));
          if(!array_key_exists('0', Input::get('savePEigenschafteninps'))){

            $ProdOBJ->updateProduct('product', htmlspecialchars(Session::get('wpid')), array('eigenschaften' => 'a'));
            $ausgabe='
            <div class="flexi-show">
              <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
              <p>Legen Sie fest, ob der Preis besteuert werden soll.</p>
              <div class="branding-name">Steuern</div>
              <div class="fieldset">
              <select id="psteuer"><option value="1">Besteuert MwSt</option><option value="2">nicht Besteuert</option></select>
              </div>
              <p>Legen Sie die Produktmenge fest. Wenn es sich um ein Variables Produkt handelt, wird der Lagerbestand automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie die Lagermenge auf Variantenebene individualisieren.</p>
              <div class="branding-name">Anzahl im Lagerbestand</div>
              <div class="fieldset">
              <input type="number" min="0" id="Lagerbestand" placeholder="Geben Sie den Lagerbestand des Produktes an">
              </div>
              <p>Legen Sie das Gewicht des Produktes fest. Wenn es sich um ein Variables Produkt handelt, wird das Gewicht automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie das Gewicht auf Variantenebene individualisieren.</p>
              <div class="branding-name">Versand Gewicht (Format: 1,000kg)</div>
              <div class="fieldset">
              <input type="text" id="pGewicht" placeholder="Geben Sie das Gewicht des Produktes an">
              </div>
              <p>Legen Sie die Packet-Länge fest. Wenn es sich um ein Variables Produkt handelt, wird die Packet-Länge automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie die Packet-Länge auf Variantenebene individualisieren.</p>
              <div class="branding-name">Packet Länge (Format: cm)</div>
              <div class="fieldset">
              <input type="text" id="plaenge" placeholder="Geben Sie die Packet-Länge des Produktes an">
              </div>
              <p>Legen Sie die Packet-Breite fest. Wenn es sich um ein Variables Produkt handelt, wird der Lagerbestand automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie die Packet-Breite auf Variantenebene individualisieren.</p>
              <div class="branding-name">Packet Breite(Format: cm)</div>
              <div class="fieldset">
              <input type="text" id="pbreite" placeholder="Geben Sie die Packet-Breite des Produktes an">
              </div>
              <p>Legen Sie die Packet-Höhe fest. Wenn es sich um ein Variables Produkt handelt, wird die Packet-Höhe automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie die Packet-Höhe auf Variantenebene individualisieren.</p>
              <div class="branding-name">Packet Höhe(Format: cm)</div>
              <div class="fieldset">
              <input type="text" id="phoch" placeholder="Geben Sie die Packet-Höhe des Produktes an">
              </div>
              <p>Geben Sie Tag-Wörter für Ihr Produkt an. Diese dienen der Suchmaschinen-Optimierung (Keywords)</p>
              <div class="branding-name">Tag-Wörter</div>
              <div class="fieldset">
              <textarea id="ProduktTags" placeholder="Geben Sie die Tag-Wörter getrennt mit Komma an..."></textarea>
              </div>
              <div class="fieldset"><div class="btn-int-admin" onclick="savelastsettProd()">Speichern und weiter >></div></div>
            </div>
            ';

            print($ausgabe);
            exit();

          }else{

                  $x=0;
                  $full_arr=array();
                  $y=0;
                  foreach(Input::get('savePEigenschafteninps') as $value){
                    if(empty(trim($value))){
                      unset($value);
                    }else{
                    $nameEig=explode(':', $value);
                    $arrkey=$nameEig[0];
                    $variant=explode(',',$nameEig[1]);
                    $e_arr=array();


                    foreach($variant as $b){
                      if(!trim($b)){

                      }else{
                        array_push($e_arr, htmlspecialchars($b));
                      }
                    }
                    $innarr=array($arrkey => $e_arr);
                    array_push($full_arr, $innarr);

                    if(Input::get('savePEigenschaftencheck')[$y]=="true"){
                      if($ProdOBJ->checkEigenschaft($nameEig[0])!=TRUE){
                        $ProdOBJ->createProduct('p_eigenschaften',array('name'=>htmlspecialchars($nameEig[0]),'e_arr'=>json_encode($e_arr)));
                      }
                    }
                    }
                    $y++;
                  }
                  if(array_key_exists('0',$full_arr)){
                    $array=json_encode($full_arr);
                  }else{
                    $array='a';
                  }
                  if($ProdOBJ->updateProduct('product', htmlspecialchars(Session::get('wpid')), array('eigenschaften' => $array))!=TRUE){
                    print 'NO';
                    exit();
                  }else{
                    $ausgabe='
                    <div class="flexi-show">
                      <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
                      <p>Legen Sie fest, ob der Preis besteuert werden soll.</p>
                      <div class="branding-name">Steuern</div>
                      <div class="fieldset">
                      <select id="psteuer"><option value="1">Besteuert MwSt</option><option value="a">nicht Besteuert</option></select>
                      </div>
                      <p>Legen Sie die Produktmenge fest. Wenn es sich um ein Variables Produkt handelt, wird der Lagerbestand automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie die Lagermenge auf Variantenebene individualisieren.</p>
                      <div class="branding-name">Anzahl im Lagerbestand</div>
                      <div class="fieldset">
                      <input type="number" min="0" id="Lagerbestand" placeholder="Geben Sie den Lagerbestand des Produktes an">
                      </div>
                      <p>Legen Sie das Gewicht des Produktes fest. Wenn es sich um ein Variables Produkt handelt, wird das Gewicht automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie das Gewicht auf Variantenebene individualisieren.</p>
                      <div class="branding-name">Versand Gewicht (Format: 1,000kg)</div>
                      <div class="fieldset">
                      <input type="text" id="pGewicht" placeholder="Geben Sie das Gewicht des Produktes an">
                      </div>
                      <p>Legen Sie die Packet-Länge fest. Wenn es sich um ein Variables Produkt handelt, wird die Packet-Länge automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie die Packet-Länge auf Variantenebene individualisieren.</p>
                      <div class="branding-name">Packet Länge (Format: cm)</div>
                      <div class="fieldset">
                      <input type="text" id="plaenge" placeholder="Geben Sie die Packet-Länge des Produktes an">
                      </div>
                      <p>Legen Sie die Packet-Breite fest. Wenn es sich um ein Variables Produkt handelt, wird der Lagerbestand automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie die Packet-Breite auf Variantenebene individualisieren.</p>
                      <div class="branding-name">Packet Breite(Format: cm)</div>
                      <div class="fieldset">
                      <input type="text" id="pbreite" placeholder="Geben Sie die Packet-Breite des Produktes an">
                      </div>
                      <p>Legen Sie die Packet-Höhe fest. Wenn es sich um ein Variables Produkt handelt, wird die Packet-Höhe automatisch<br>auf die Varianten übernommen. Im nächsten Schritt können Sie die Packet-Höhe auf Variantenebene individualisieren.</p>
                      <div class="branding-name">Packet Höhe(Format: cm)</div>
                      <div class="fieldset">
                      <input type="text" id="phoch" placeholder="Geben Sie die Packet-Höhe des Produktes an">
                      </div>
                      <p>Geben Sie Tag-Wörter für Ihr Produkt an. Diese dienen der Suchmaschinen-Optimierung (Keywords)</p>
                      <div class="branding-name">Tag-Wörter</div>
                      <div class="fieldset">
                      <textarea id="ProduktTags" placeholder="Geben Sie die Tag-Wörter getrennt mit Komma an..."></textarea>
                      </div>
                      <div class="fieldset"><div class="btn-int-admin" onclick="savelastsettProd()">Speichern und weiter >></div></div>
                    </div>
                    ';

                    print($ausgabe);
                    exit();
                  }

          }



        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('aktualVariantspid')){
          $pid=htmlspecialchars(Input::get('aktualVariantspid'));
          if($ProdOBJ->getProdukt('product', $pid)->eigenschaften=="a"){
            print 'OK';
            exit();
          }else{
              $eigenschaften=json_decode($ProdOBJ->getProdukt('product', $pid)->eigenschaften);
              $preis=$ProdOBJ->getProdukt('product', $pid)->price;
              $preisneu=$ProdOBJ->getProdukt('product', $pid)->newprice;
              $preisrabatt=$ProdOBJ->getProdukt('product', $pid)->rabattprice;
              $gewicht=$ProdOBJ->getProdukt('product', $pid)->p_weight;
              $long=$ProdOBJ->getProdukt('product', $pid)->p_deep;
              $breit=$ProdOBJ->getProdukt('product', $pid)->p_width;
              $height=$ProdOBJ->getProdukt('product', $pid)->p_height;
              $quant=$ProdOBJ->getProdukt('product', $pid)->p_quant;


              $anzahlEigenschaften=count($eigenschaften);
                  $output='';
                  if($anzahlEigenschaften==1){
                    foreach ($eigenschaften[0] as $key => $value) {
                      $name=$key;
                      foreach ($value as $eig) {
                        $listing='';
                        foreach(json_decode($ProdOBJ->getProdukt('p_images', $pid)->img_arr) as $k => $img){
                          if($k==$ProdOBJ->getProdukt('p_images',$pid)->front_img){
                            $listing.='<img src="img/products/'.$img.'" id="'.$eig.$k.$name.'" class="choosegallery" style="border:0.4em solid #00FF00;width:5em;" onclick="changeFImgV(\''.$k.'\',\''.$eig.'\',\''.$img.'\',\''.$name.'\')" />
                                      <input type="hidden" value="'.$k.'" id="frontimgonV" class="fimg'.$eig.$name.'" />
                                      <input type="hidden" value="'.$img.'" name="frontimgonVSRC" id="frontimgonVSRC" class="fimgsrc'.$eig.$name.'" />';
                          }else{
                            $listing.='<img src="img/products/'.$img.'" id="'.$eig.$k.$name.'" class="choosegallery" style="width:5em;" onclick="changeFImgV(\''.$k.'\',\''.$eig.'\',\''.$img.'\',\''.$name.'\')" />';
                          }
                        }
                        $output.='
                        <div class="branding-name">'.$name.': '.$eig.'</div>
                        <input type="hidden" value="'.$eig.'" name="variablenamekey" id="variablenamekey" />
                        <div class="fieldset">
                        '.$listing.'
                        </div>
                        <div class="fieldset">
                        <div class="inpfloater">
                        <label>Lagerbestand</label>
                        <input type="number" min="0" name="VPanzahl" value="'.$quant.'" id="VPanzahl" placeholder="Geben Sie den Lagerbestand des Produktes an">
                        </div>
                        <div class="inpfloater">
                        <label>Preis</label>
                        <input type="text" id="VPpreis" name="VPpreis" value="'.$preis.'" placeholder="Legen Sie den Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>UVP-Preis</label>
                        <input type="text" id="VPneupreis" name="VPneupreis" value="'.$preisneu.'" placeholder="Legen Sie den UVP-Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Rabatt-Preis</label>
                        <input type="text" id="VPrabattpreis" name="VPrabattpreis" value="'.$preisrabatt.'" placeholder="Legen Sie den Rabatt-Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Gewicht</label>
                        <input type="text" id="VPgewicht" name="VPgewicht" value="'.$gewicht.'" placeholder="Legen Sie das Gewicht der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Länge</label>
                        <input type="text" id="VPlong" name="VPlong" value="'.$long.'" placeholder="Legen Sie die Paket-Länge der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Breite</label>
                        <input type="text" id="VPbreite" name="VPbreite" value="'.$breit.'" placeholder="Legen Sie die Paket-Breite der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Höhe</label>
                        <input type="text" id="VPhohe" name="VPhohe" value="'.$height.'" placeholder="Legen Sie die Paket-Höhe der Variante fest">
                        </div>
                        </div>';
                      }

                    }
                  }elseif ($anzahlEigenschaften==2) {
                    foreach ($eigenschaften as $key => $value) {
                      if($key==0){
                        foreach ($value as $k => $val) {
                          $name1=$k;
                        }
                      }else{
                        foreach ($value as $k => $val) {
                          $name2=$k;
                        }
                      }
                    }
                    foreach ($eigenschaften[0]->$name1 as $k => $val) {
                      foreach ($eigenschaften[1]->$name2 as $value) {
                        $listing='';
                        foreach(json_decode($ProdOBJ->getProdukt('p_images', $pid)->img_arr) as $b => $img){
                          if($b==$ProdOBJ->getProdukt('p_images',$pid)->front_img){
                            $listing.='<img src="img/products/'.$img.'" id="'.$val.'_'.$value.$b.$name1.$name2.'" class="choosegallery" style="border:0.4em solid #00FF00;width:5em;" onclick="changeFImgV(\''.$b.'\',\''.$val.'_'.$value.'\',\''.$img.'\',\''.$name1.$name2.'\')" />
                                      <input type="hidden" value="'.$b.'" id="frontimgonV" class="fimg'.$val.'_'.$value.$name1.$name2.'" />
                                      <input type="hidden" value="'.$img.'" name="frontimgonVSRC" id="frontimgonVSRC" class="fimgsrc'.$val.'_'.$value.$name1.$name2.'" />';
                          }else{
                            $listing.='<img src="img/products/'.$img.'" id="'.$val.'_'.$value.$b.$name1.$name2.'" class="choosegallery" style="width:5em;" onclick="changeFImgV(\''.$b.'\',\''.$val.'_'.$value.'\',\''.$img.'\',\''.$name1.$name2.'\')" />';
                          }
                        }
                        $output.='
                        <div class="branding-name">'.$name1.': '.$val.' / '.$name2.': '.$value.'</div>
                        <input type="hidden" value="'.$val.'_'.$value.'" name="variablenamekey" id="variablenamekey" />
                        <div class="fieldset">
                        '.$listing.'
                        </div>
                        <div class="fieldset">
                        <div class="inpfloater">
                        <label>Lagerbestand</label>
                        <input type="number" min="0" name="VPanzahl" value="'.$quant.'" id="VPanzahl" placeholder="Geben Sie den Lagerbestand des Produktes an">
                        </div>
                        <div class="inpfloater">
                        <label>Preis</label>
                        <input type="text" id="VPpreis" name="VPpreis" value="'.$preis.'" placeholder="Legen Sie den Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>UVP-Preis</label>
                        <input type="text" id="VPneupreis" name="VPneupreis" value="'.$preisneu.'" placeholder="Legen Sie den UVP-Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Rabatt-Preis</label>
                        <input type="text" id="VPrabattpreis" name="VPrabattpreis" value="'.$preisrabatt.'" placeholder="Legen Sie den Rabatt-Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Gewicht</label>
                        <input type="text" id="VPgewicht" name="VPgewicht" value="'.$gewicht.'" placeholder="Legen Sie das Gewicht der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Länge</label>
                        <input type="text" id="VPlong" name="VPlong" value="'.$long.'" placeholder="Legen Sie die Paket-Länge der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Breite</label>
                        <input type="text" id="VPbreite" name="VPbreite" value="'.$breit.'" placeholder="Legen Sie die Paket-Breite der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Höhe</label>
                        <input type="text" id="VPhohe" name="VPhohe" value="'.$height.'" placeholder="Legen Sie die Paket-Höhe der Variante fest">
                        </div>
                        </div>';
                      }

                    }
                  }elseif ($anzahlEigenschaften==3) {
                    foreach ($eigenschaften as $key => $value) {
                      if($key==0){
                        foreach ($value as $k => $val) {
                          $name1=$k;
                        }
                      }else{
                        foreach ($value as $k => $val) {
                          $name2=$k;
                        }
                      }
                    }
                    foreach ($eigenschaften[0]->$name1 as $k => $val) {
                      foreach ($eigenschaften[1]->$name2 as $value) {
                        $listing='';
                        foreach(json_decode($ProdOBJ->getProdukt('p_images', $pid)->img_arr) as $b => $img){
                          if($b==$ProdOBJ->getProdukt('p_images',$pid)->front_img){
                            $listing.='<img src="img/products/'.$img.'" id="'.$val.'_'.$value.$b.$name1.$name2.'" class="choosegallery" style="border:0.4em solid #00FF00;width:5em;" onclick="changeFImgV(\''.$b.'\',\''.$val.'_'.$value.'\',\''.$img.'\',\''.$name1.$name2.'\')" />
                                      <input type="hidden" value="'.$b.'" id="frontimgonV" class="fimg'.$val.'_'.$value.$name1.$name2.'" />
                                      <input type="hidden" value="'.$img.'" name="frontimgonVSRC" id="frontimgonVSRC" class="fimgsrc'.$val.'_'.$value.$name1.$name2.'" />';
                          }else{
                            $listing.='<img src="img/products/'.$img.'" id="'.$val.'_'.$value.$b.$name1.$name2.'" class="choosegallery" style="width:5em;" onclick="changeFImgV(\''.$b.'\',\''.$val.'_'.$value.'\',\''.$img.'\',\''.$name1.$name2.'\')" />';
                          }
                        }
                        $output.='
                        <div class="branding-name">'.$name1.': '.$val.' / '.$name2.': '.$value.'</div>
                        <input type="hidden" value="'.$val.'_'.$value.'" name="variablenamekey" id="variablenamekey" />
                        <div class="fieldset">
                        '.$listing.'
                        </div>
                        <div class="fieldset">
                        <div class="inpfloater">
                        <label>Lagerbestand</label>
                        <input type="number" min="0" name="VPanzahl" value="'.$quant.'" id="VPanzahl" placeholder="Geben Sie den Lagerbestand des Produktes an">
                        </div>
                        <div class="inpfloater">
                        <label>Preis</label>
                        <input type="text" id="VPpreis" name="VPpreis" value="'.$preis.'" placeholder="Legen Sie den Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>UVP-Preis</label>
                        <input type="text" id="VPneupreis" name="VPneupreis" value="'.$preisneu.'" placeholder="Legen Sie den UVP-Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Rabatt-Preis</label>
                        <input type="text" id="VPrabattpreis" name="VPrabattpreis" value="'.$preisrabatt.'" placeholder="Legen Sie den Rabatt-Preis der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Gewicht</label>
                        <input type="text" id="VPgewicht" name="VPgewicht" value="'.$gewicht.'" placeholder="Legen Sie das Gewicht der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Länge</label>
                        <input type="text" id="VPlong" name="VPlong" value="'.$long.'" placeholder="Legen Sie die Paket-Länge der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Breite</label>
                        <input type="text" id="VPbreite" name="VPbreite" value="'.$breit.'" placeholder="Legen Sie die Paket-Breite der Variante fest">
                        </div>
                        <div class="inpfloater">
                        <label>Paket-Höhe</label>
                        <input type="text" id="VPhohe" name="VPhohe" value="'.$height.'" placeholder="Legen Sie die Paket-Höhe der Variante fest">
                        </div>
                        </div>';
                      }

                    }
                  }else{
                    print 'OK';
                    exit();
                  }

                  $ausausgabe='
                    '.$output.'
                    <div class="fieldset"><div class="btn-int-admin" onclick="saveVarianten(\''.$pid.'\')">Speichern</div></div>
                  ';
                  print $ausausgabe;
                  exit();


          }
        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('steuer')){
          (Input::get('steuer')=="a")? $steuer=0 : $steuer=htmlspecialchars(Input::get('steuer'));
          (!Input::get('menge'))? $menge=0 : $menge=htmlspecialchars(Input::get('menge'));
          (!Input::get('gewicht'))? $gewicht=0 : $gewicht=htmlspecialchars(Input::get('gewicht'));
          (!Input::get('laenge'))? $laenge=0 : $laenge=htmlspecialchars(Input::get('laenge'));
          (!Input::get('breite'))? $breite=0 : $breite=htmlspecialchars(Input::get('breite'));
          (!Input::get('hoehe'))? $hoehe=0 : $hoehe=htmlspecialchars(Input::get('hoehe'));
          (!Input::get('tagswords'))? $tagswords=0 : $tagswords=htmlspecialchars(Input::get('tagswords'));
          //gewicht, anzahl, länge, breite, höhe, preis, neupreis, rabattpreis, gallerybild



          if($tagswords==0){
            $tagswords=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->name;
            $tagswords=preg_split('/\s+/', $tagswords);
            $wordlist='';
            $addsecondkat=json_decode($ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->undKat_id);
            foreach ($addsecondkat as $value) {

                $wordlist.=$value.',';

            }
            $max=count($tagswords);
            foreach ($tagswords as $key => $value) {
              if($key==$max-1){
                $wordlist.=$value;
              }else{
                $wordlist.=$value.',';
              }
            }


            $tagswords=$wordlist;
          }

          if($ProdOBJ->updateProduct('product', htmlspecialchars(Session::get('wpid')), array(
            'tax_type' => $steuer,
            'p_quant' => $menge,
            'p_weight' => $gewicht,
            'p_width' => $breite,
            'p_height' => $hoehe,
            'p_deep' => $laenge,
            'p_tagwort' => $tagswords,
            'variable_arr' => 'a'
          ))!=TRUE){
            print 'NO';
            exit();
          }else{
            //Variable ausgabe
            //Check if variable product for another output, otherwise, jump back to start
              if($ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->p_type==2){
                //Variable output
                if($ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->eigenschaften=="a"){
                  print 'OK';
                  exit();
                }else{
                    $eigenschaften=json_decode($ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->eigenschaften);
                    $preis=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->price;
                    $preisneu=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->newprice;
                    $preisrabatt=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->rabattprice;
                    $gewicht=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->p_weight;
                    $long=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->p_deep;
                    $breit=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->p_width;
                    $height=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->p_height;
                    $quant=$ProdOBJ->getProdukt('product', htmlspecialchars(Session::get('wpid')))->p_quant;


                    $anzahlEigenschaften=count($eigenschaften);
                        $output='';
                        if($anzahlEigenschaften==1){
                          foreach ($eigenschaften[0] as $key => $value) {
                            $name=$key;
                            foreach ($value as $eig) {
                              $listing='';
                              foreach(json_decode($ProdOBJ->getProdukt('p_images', htmlspecialchars(Session::get('wpid')))->img_arr) as $k => $img){
                                if($k==$ProdOBJ->getProdukt('p_images',htmlspecialchars(Session::get('wpid')))->front_img){
                                  $listing.='<img src="img/products/'.$img.'" id="'.$eig.$k.$name.'" class="choosegallery" style="border:0.4em solid #00FF00;width:5em;" onclick="changeFImgV(\''.$k.'\',\''.$eig.'\',\''.$img.'\',\''.$name.'\')" />
                                            <input type="hidden" value="'.$k.'" id="frontimgonV" class="fimg'.$eig.$name.'" />
                                            <input type="hidden" value="'.$img.'" name="frontimgonVSRC" id="frontimgonVSRC" class="fimgsrc'.$eig.$name.'" />';
                                }else{
                                  $listing.='<img src="img/products/'.$img.'" id="'.$eig.$k.$name.'" class="choosegallery" style="width:5em;" onclick="changeFImgV(\''.$k.'\',\''.$eig.'\',\''.$img.'\',\''.$name.'\')" />';
                                }
                              }
                              $output.='
                              <div class="branding-name">'.$name.': '.$eig.'</div>
                              <input type="hidden" value="'.$eig.'" name="variablenamekey" id="variablenamekey" />
                              <div class="fieldset">
                              '.$listing.'
                              </div>
                              <div class="fieldset">
                              <div class="inpfloater">
                              <label>Lagerbestand</label>
                              <input type="number" min="0" name="VPanzahl" value="'.$quant.'" id="VPanzahl" placeholder="Geben Sie den Lagerbestand des Produktes an">
                              </div>
                              <div class="inpfloater">
                              <label>Preis</label>
                              <input type="text" id="VPpreis" name="VPpreis" value="'.$preis.'" placeholder="Legen Sie den Preis der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>UVP-Preis</label>
                              <input type="text" id="VPneupreis" name="VPneupreis" value="'.$preisneu.'" placeholder="Legen Sie den UVP-Preis der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Rabatt-Preis</label>
                              <input type="text" id="VPrabattpreis" name="VPrabattpreis" value="'.$preisrabatt.'" placeholder="Legen Sie den Rabatt-Preis der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Gewicht</label>
                              <input type="text" id="VPgewicht" name="VPgewicht" value="'.$gewicht.'" placeholder="Legen Sie das Gewicht der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Paket-Länge</label>
                              <input type="text" id="VPlong" name="VPlong" value="'.$long.'" placeholder="Legen Sie die Paket-Länge der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Paket-Breite</label>
                              <input type="text" id="VPbreite" name="VPbreite" value="'.$breit.'" placeholder="Legen Sie die Paket-Breite der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Paket-Höhe</label>
                              <input type="text" id="VPhohe" name="VPhohe" value="'.$height.'" placeholder="Legen Sie die Paket-Höhe der Variante fest">
                              </div>
                              </div>';
                            }

                          }
                        }elseif ($anzahlEigenschaften==2) {
                          foreach ($eigenschaften as $key => $value) {
                            if($key==0){
                              foreach ($value as $k => $val) {
                                $name1=$k;
                              }
                            }else{
                              foreach ($value as $k => $val) {
                                $name2=$k;
                              }
                            }
                          }
                          foreach ($eigenschaften[0]->$name1 as $k => $val) {
                            foreach ($eigenschaften[1]->$name2 as $value) {
                              $listing='';
                              foreach(json_decode($ProdOBJ->getProdukt('p_images', htmlspecialchars(Session::get('wpid')))->img_arr) as $b => $img){
                                if($b==$ProdOBJ->getProdukt('p_images',htmlspecialchars(Session::get('wpid')))->front_img){
                                  $listing.='<img src="img/products/'.$img.'" id="'.$val.'_'.$value.$b.$name1.$name2.'" class="choosegallery" style="border:0.4em solid #00FF00;width:5em;" onclick="changeFImgV(\''.$b.'\',\''.$val.'_'.$value.'\',\''.$img.'\',\''.$name1.$name2.'\')" />
                                            <input type="hidden" value="'.$b.'" id="frontimgonV" class="fimg'.$val.'_'.$value.$name1.$name2.'" />
                                            <input type="hidden" value="'.$img.'" name="frontimgonVSRC" id="frontimgonVSRC" class="fimgsrc'.$val.'_'.$value.$name1.$name2.'" />';
                                }else{
                                  $listing.='<img src="img/products/'.$img.'" id="'.$val.'_'.$value.$b.$name1.$name2.'" class="choosegallery" style="width:5em;" onclick="changeFImgV(\''.$b.'\',\''.$val.'_'.$value.'\',\''.$img.'\',\''.$name1.$name2.'\')" />';
                                }
                              }
                              $output.='
                              <div class="branding-name">'.$name1.': '.$val.' / '.$name2.': '.$value.'</div>
                              <input type="hidden" value="'.$val.'_'.$value.'" name="variablenamekey" id="variablenamekey" />
                              <div class="fieldset">
                              '.$listing.'
                              </div>
                              <div class="fieldset">
                              <div class="inpfloater">
                              <label>Lagerbestand</label>
                              <input type="number" min="0" name="VPanzahl" value="'.$quant.'" id="VPanzahl" placeholder="Geben Sie den Lagerbestand des Produktes an">
                              </div>
                              <div class="inpfloater">
                              <label>Preis</label>
                              <input type="text" id="VPpreis" name="VPpreis" value="'.$preis.'" placeholder="Legen Sie den Preis der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>UVP-Preis</label>
                              <input type="text" id="VPneupreis" name="VPneupreis" value="'.$preisneu.'" placeholder="Legen Sie den UVP-Preis der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Rabatt-Preis</label>
                              <input type="text" id="VPrabattpreis" name="VPrabattpreis" value="'.$preisrabatt.'" placeholder="Legen Sie den Rabatt-Preis der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Gewicht</label>
                              <input type="text" id="VPgewicht" name="VPgewicht" value="'.$gewicht.'" placeholder="Legen Sie das Gewicht der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Paket-Länge</label>
                              <input type="text" id="VPlong" name="VPlong" value="'.$long.'" placeholder="Legen Sie die Paket-Länge der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Paket-Breite</label>
                              <input type="text" id="VPbreite" name="VPbreite" value="'.$breit.'" placeholder="Legen Sie die Paket-Breite der Variante fest">
                              </div>
                              <div class="inpfloater">
                              <label>Paket-Höhe</label>
                              <input type="text" id="VPhohe" name="VPhohe" value="'.$height.'" placeholder="Legen Sie die Paket-Höhe der Variante fest">
                              </div>
                              </div>';
                            }

                          }
                        }elseif ($anzahlEigenschaften==3) {
                          // code...
                        }else{
                          print 'OK';
                          exit();
                        }

                        $ausausgabe='<div class="flexi-show">
                          <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
                          '.$output.'
                          <div class="fieldset"><div class="btn-int-admin" onclick="saveVarianten(\'N\')">Speichern und weiter >></div></div>
                        </div>';
                        print $ausausgabe;
                        exit();


                }

              }else{
                //jump back to start
                print 'OK';
                exit();
              }
          }

        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('VNameKey')){
          $elements=count(Input::get('VNameKey'));
          $garr=array();
          $x=0;
          foreach (Input::get('VNameKey') as $key => $value) {
            array_push($garr, array(
              'id' => htmlspecialchars(Input::get('VNameKey')[$x]),
              'Fimg' => htmlspecialchars(Input::get('VFrontImg')[$x]),
              'Preis' => htmlspecialchars(Input::get('VProdPreis')[$x]),
              'UVP' => htmlspecialchars(Input::get('VPneupreis')[$x]),
              'Rabatt' => htmlspecialchars(Input::get('VPdispreis')[$x]),
              'Gewicht' => htmlspecialchars(Input::get('VPGewicht')[$x]),
              'Long' => htmlspecialchars(Input::get('VProdlong')[$x]),
              'Breite' => htmlspecialchars(Input::get('VPBreite')[$x]),
              'Hohe' => htmlspecialchars(Input::get('VPHohe')[$x])
            ));
            $x++;
          }
          if(htmlspecialchars(Input::get('VPPid'))=='N'){
                if($ProdOBJ->updateProduct('product', htmlspecialchars(Session::get('wpid')), array('	variable_arr' => json_encode($garr)))!=TRUE){
                  print 'NO';
                  exit();
                }else{

                  print 'OK';
                  exit();
                }
          }else{
                if($ProdOBJ->updateProduct('product', htmlspecialchars(Input::get('VPPid')), array('	variable_arr' => json_encode($garr)))!=TRUE){
                  print 'NO';
                  exit();
                }else{

                  print 'OK';
                  exit();
                }
          }

        }
        /*
        Ausgabe des HTML NEW PRODUKT 1
        */
        if(Input::get('TextVorschauBeschreibung')){




          if(preg_match('[img]', Input::get('TextVorschauBeschreibung'))){
            $b=explode('[img]', htmlspecialchars(Input::get('TextVorschauBeschreibung')));
            $out='';
              foreach($b as $value){
                if(preg_match('[/img]', $value)){
                    $c=explode('[/img]', $value);
                        if(!preg_match("/(_)/", $c[0])){
                          $nval='<img src="img/products/'.$c[0].'" class="productdescImg" /> '.$c[1].' ';
                          $out.=$nval;
                        }else{
                          $d=explode("_", $c[0]);
                          $nval='<img src="img/products/'.$d[0].'" class="productdescImg" style="width:'.$d[1].'%;" /> '.$c[1].' ';
                          $out.=$nval;

                        }
                }else{
                  $out.=$value;
                }
              }
              print(nl2br($out));
              exit();
          }else{
            print Input::get('TextVorschauBeschreibung');
            exit();
          }

        }
        /*
        Ausgabe des HTML NEW PRODUKT 1 choosegallerypic
        */
        if(Input::get('makeitgallery')||Input::get('makeitgallery')=='0'){
          if($ProdOBJ->updateProduct('p_images', htmlspecialchars(Session::get('wpid')), array('front_img' => htmlspecialchars(Input::get('makeitgallery'))))!=TRUE){
            print 'NO';
            exit();
          }
          $listing='';
              foreach(json_decode($ProdOBJ->getProdukt('p_images', htmlspecialchars(Session::get('wpid')))->img_arr) as $key => $value){
                if($key==$ProdOBJ->getProdukt('p_images',htmlspecialchars(Session::get('wpid')))->front_img){
                  $listing.='<img src="img/products/'.$value.'" class="choosegallery" style="border:0.4em solid #00FF00;" onclick="setAsGallery(\''.$key.'\')" />';
                }else{
                  $listing.='<img src="img/products/'.$value.'" class="choosegallery" onclick="setAsGallery(\''.$key.'\')" />';
                }
              }
          print $listing;
          exit();
        }

  }
}
?>
