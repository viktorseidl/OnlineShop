<?php
include 'globals.php';
$user= new User();
if($user->hasPermission('admin')){
  if(Input::exists()){
      $CatOBJ=new Category();
      /*
      Image Upload Slider
      */
      if(Input::get('typ')){
      $type=Input::get('typ');
      $kat=Input::get('kat');
      if (isset($_FILES[$type]["tmp_name"])) {
            $fileName = $_FILES[$type]["name"];
            $fileTmpLoc = $_FILES[$type]["tmp_name"];
            $fileType = $_FILES[$type]["type"];
            $fileSize = $_FILES[$type]["size"];
            $fileErrorMsg = $_FILES[$type]["error"]; 
              if(Input::get('typ')){
                    $extention= explode(".", $fileName);
                    $extention= end($extention);
                    $fileName='kat_'.$kat.'.'.$extention;
              }

            if(move_uploaded_file($fileTmpLoc, "../../img/$fileName")){
                if($CatOBJ->updateKat(htmlspecialchars($kat), array('top_kat_img' => $fileName))!=True){
                      echo "NO";
                      exit();
                }else{
                      echo $fileName;
                      exit();
                }
            } else {
                  echo "NO";
                  exit();
            }
      }else{
            echo "ERROR";
            exit();
      }
    }
          /*
          New Category and maybe Sub-Category
          */
          if(Input::get('nTopKat') && (Input::get('nUndKat'))){
          $Tkat=htmlspecialchars(Input::get('nTopKat'));
          $Ukat=explode(',',Input::get('nUndKat'));
          $Uarray=array();
          foreach ($Ukat as $value) {
            $UarrKat=htmlspecialchars(preg_replace("[^A-Za-z]", '', $value));
            $UarrKat=trim($UarrKat);
            if(empty($UarrKat) && ($UarrKat==null) ){

            }else{
            array_push($Uarray, htmlspecialchars($UarrKat));
            }
          }

              if($CatOBJ->newKat(array('top_kat' => $Tkat ))!=TRUE){
                print 'NO';
                exit();
              }else{
                    if(empty($Uarray[0])){
                          print 'OK';
                          exit();
                    }else{
                          if($CatOBJ->updateKat($Tkat,array('und_kat' => json_encode($Uarray)))!=TRUE){
                            print 'NO';
                            exit();
                          }else{
                            print 'OK';
                            exit();
                          }
                    }
              }

        }
        /*
        New Category and maybe Sub-Category
        */
        if(Input::get('lUKat_key') && (Input::get('lUKat_kat'))){
          $key=htmlentities(Input::get('lUKat_key'));
          $existing_arr=json_decode($CatOBJ->getKat(htmlspecialchars(Input::get('lUKat_kat')))->und_kat);
          unset($existing_arr[$key]);
          if($CatOBJ->updateKat(htmlspecialchars(Input::get('lUKat_kat')),array('und_kat' => json_encode($existing_arr)))!=TRUE){
              print 'NO';
              exit();
          }else{
              print 'OK';
              exit();
          }

        }
        /*
        Delete BackgroundLogo TopKat
        */
        if(Input::get('deleteBKTLogo')){
          $deleteBKTLogo=$CatOBJ->getKat(htmlspecialchars(Input::get('deleteBKTLogo')))->top_kat_img;
          if(unlink('../../img/'.$deleteBKTLogo)){
            if($CatOBJ->updateKat(htmlspecialchars(Input::get('deleteBKTLogo')),array('top_kat_img' => 'a'))!=TRUE){
                print 'NO';
                exit();
            }else{
                print 'OK';
                exit();
            }
          }else{
            print 'NO';
            exit();
          }


        }
        /*
        Delete BackgroundLogo TopKat
        */
        if(Input::get('leteTopkat')){
          $leteTopkat=$CatOBJ->getKat(htmlspecialchars(Input::get('leteTopkat')))->top_kat_img;
          if(file_exists('../../img/'.$leteTopkat)){
                if(unlink('../../img/'.$leteTopkat)){
                  if($CatOBJ->deleteKat(htmlspecialchars(Input::get('leteTopkat')))!=TRUE){
                      print 'NO';
                      exit();
                  }else{
                      print 'OK';
                      exit();
                  }
                }else{
                  print 'NO';
                  exit();
                }
          }else{
            if($CatOBJ->deleteKat(htmlspecialchars(Input::get('leteTopkat')))!=TRUE){
                print 'NO';
                exit();
            }else{
                print 'OK';
                exit();
            }
          }


        }
        /*
        Save Icon and maybe Sub-Category
        */
        if(Input::get('sKE_typ') && (Input::get('sKE_inp')) && (Input::get('sKE_kat'))){
        $Tkat=Input::get('sKE_inp');
        switch (Input::get('sKE_typ')) {
          case 'i':
                  if($CatOBJ->updateKat(htmlspecialchars(Input::get('sKE_kat')),array('top_kat_icon' => $Tkat))!=TRUE){
                      print 'NO';
                      exit();
                  }else{
                      print 'OK';
                      exit();
                  }
          break;
          case 'u':
                  $existing_arr=json_decode($CatOBJ->getKat(htmlspecialchars(Input::get('sKE_kat')))->und_kat);
                      if(is_array($existing_arr)){
                        $Uarray=$existing_arr;
                      }else{
                        $Uarray=array();
                      }
                  $Ukat=explode(',',Input::get('sKE_inp'));

                  foreach ($Ukat as $value) {
                      $UarrKat=htmlspecialchars(preg_replace("[^A-Za-z]", '', $value));
                      $UarrKat=trim($UarrKat);
                      if(empty($UarrKat) && ($UarrKat==null) ){

                      }else{
                      array_push($Uarray, htmlspecialchars($UarrKat));
                      }
                  }
                  if($CatOBJ->updateKat(htmlspecialchars(Input::get('sKE_kat')),array('und_kat' => json_encode($Uarray)))!=TRUE){
                      print 'NO';
                      exit();
                  }else{
                      print 'OK';
                      exit();
                  }
          break;

          default:
            print 'NO';
            exit();
            break;
        }

      }
        /*
        Ausgabe des HTML
        */
        if(Input::get('EditKat')){
          if(is_numeric(Input::get('EditKat'))){
            if($CatOBJ->getKat(htmlspecialchars(Input::get('EditKat')))){
              $list='';
              foreach(json_decode($CatOBJ->getKat(htmlspecialchars(Input::get('EditKat')))->und_kat) as $key => $value){
                $list.='<div id="UnTabedit'.$key.'" class="existing-sub-rows"><a>'.$value.'</a><i onclick="leteUnderkat(\''.$key.'\',\''.htmlspecialchars(Input::get('EditKat')).'\')" class="fas fa-trash-alt"></i></div>';
              }
              $top_kat_img='pholder.png';
              if($CatOBJ->getKat(htmlspecialchars(Input::get('EditKat')))->top_kat_img!='a'){
                $top_kat_img=$CatOBJ->getKat(htmlspecialchars(Input::get('EditKat')))->top_kat_img;
              }
              $icon=$CatOBJ->getKat(htmlspecialchars(Input::get('EditKat')))->top_kat_icon;
              if($icon=="a"){
                $icon='';
              }
              $ausgabe='
              <div class="bordering">
                  <h4>'.$CatOBJ->getKat(htmlspecialchars(Input::get('EditKat')))->top_kat.'</h4>
                  <hr>
                  <div class="fieldset">
                      <label for="nTopKat">Icon anlegen (Font-Awesome - z.B:'.htmlspecialchars('<i></i>').')</label>
                      <input type="text" name="newkat" id="nTopKatIcon" value="'.htmlentities($icon).'" placeholder="Geben Sie die Icon-Tags (<i></i>) von Font-Awesome an..." />
                      <div class="fieldset"><div class="btn-int-admin" onclick="saveKatsEdit(\'i\',\''.Input::get('EditKat').'\')">Speichern</div></div>
                  </div>
                  <div class="fieldset">
                      <label for="nTopKat">Unter-Kategorien hinzufügen oder löschen</label>
                      <input type="text" name="newkat" id="newUKat" placeholder="Unter-Kategorien angeben und mit Komma (,) trennen..." />
                      <div class="fieldset"><div class="btn-int-admin" onclick="saveKatsEdit(\'u\',\''.Input::get('EditKat').'\')">Jetzt hinzufügen</div></div>
                      <label for="nTopKat">Bestehende Unter-Kategorien</label>
                      <div class="existing-sub" id="UndKatslistdiv">
                      '.$list.'
                      </div>
                  </div>
                  <div class="fieldset">
                    <form id="upload_form" enctype="multipart/form-data" method="post">
                    <label>Background Foto für Kategorie festlegen</label>
                    <div class="fieldset"><img id="admin-katlogo" src="img/'.$top_kat_img.'" /><div class="btn-int-admin" style="margin-top:-2em;" onclick="deleteBKTLogo(\''.Input::get('EditKat').'\')">Löschen</div></div>
                    <input type="file" name="slider_1" id="slider_1" onchange="uploadFile(\'slider_1\',\''.Input::get('EditKat').'\')"><br>
                    <progress id="progressBar" value="0" max="100"></progress><br>
                    <span id="filemsg"></span>
                    </form>
                  </div>
                  <div class="fieldset">
                    <div class="fieldset"><div class="btn-int-admin" onclick="reloadEditKat()">Schließen</div></div>
                  </div>
              </div>
              ';
              echo $ausgabe;
              exit();
            }else{
              echo 'NO';
              exit();
            }
          }else{
            echo 'NO';
            exit();
          }
        }
        /*
        Ausgabe des HTML
        */
        if(Input::get('reloadEditKat')){
          if($CatOBJ->getKat()){
            $ausgabe='<div class="fieldset">
              <label for="eTopKat">Zu bearbeitende Kategorie auswählen</label>
              <select onchange="loadEditKat()" name="eTopKat" id="eTopKat"><option >Auswählen</option>';

            foreach ($CatOBJ->getKat() as $value) {
              $ausgabe.='<option style="color:#000000;" value="'.$value->id.'">'.$value->top_kat.'</option>';

            }

            $ausgabe.='
            </select>
          </div>
            ';

          }else{

              $ausgabe='
                    <option style="color:#000000;" >Auswählen</option>
              ';

          }
          echo $ausgabe;
          exit();
        }
        /*
        Ausgabe des HTML
        */
        if(Input::get('updateTopKatlist')){
          if($CatOBJ->getKat()){
            $list='';
            foreach ($CatOBJ->getKat() as $value) {
              $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows"><a>'.$value->top_kat.'</a><i onclick="leteTopkat(\''.$value->id.'\')" class="fas fa-trash-alt"></i></div>';
            }
            $ausgabe=$list;

          }else{
              $ausgabe='';
          }
          echo $ausgabe;
          exit();
        }
        /*
        Ausgabe des HTML
        */
        if(Input::get('refreshUkats')){
          if($CatOBJ->getKat(htmlspecialchars(Input::get('refreshUkats')))->und_kat){
            $ausgabe='';
            foreach(json_decode($CatOBJ->getKat(htmlspecialchars(Input::get('refreshUkats')))->und_kat) as $key => $value){
              $ausgabe.='<div id="UnTabedit'.$key.'" class="existing-sub-rows"><a>'.$value.'</a><i onclick="leteUnderkat(\''.$key.'\',\''.Input::get('refreshUkats').'\')" class="fas fa-trash-alt"></i></div>';
            }

          }else{

              $ausgabe='
                    <option style="color:#000000;" >Auswählen</option>
              ';

          }
          echo $ausgabe;
          exit();
        }
        /*
        Ausgabe des HTML
        */
        if(Input::get('Ausgabe')){
          if($CatOBJ->getKat()){
            $select='<option >Auswählen</option>';
            $list='';
          foreach ($CatOBJ->getKat() as $value) {
            $select.='<option style="color:#000000;" value="'.$value->id.'">'.$value->top_kat.'</option>';
            $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows"><a>'.$value->top_kat.'</a><i onclick="leteTopkat(\''.$value->id.'\')" class="fas fa-trash-alt"></i></div>';
          }

          }else{

              $select='
                    <option style="color:#000000;" >Auswählen</option>
              ';

          }
          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-list-ul"></i> Kategorien</h3><hr>
            <p>Hier haben Sie die Möglichkeit, die Kategorien Ihres Shops und die zugehörigen Unter-Kategorien festzulegen oder zu bearbeiten.</p>
            <div class="branding-name">Bestehende Kategorie löschen</div>
            <div class="existing-sub" id="TopkastListdiv">
            '.$list.'
            </div>
            <div class="branding-name">Bestehende Kategorie und Unter-Kategorie bearbeiten</div>
            <div class="editing-div-loader1">
            <div class="fieldset">
              <label for="eTopKat">Zu bearbeitende Kategorie auswählen</label>
              <select onchange="loadEditKat()" name="eTopKat" id="eTopKat">
                '.$select.'
              </select>
            </div>
            </div>
            <div class="branding-name">Neue Kategorie anlegen</div>
            <div class="editing-div-loader2">
            <div class="fieldset">
              <label for="nTopKat">Name der Kategorie anlegen</label>
              <input type="text" name="newkat" id="nTopKat" placeholder="Geben Sie den Namen der neuen Kategorie an...(z.B.: Mode)" />
            </div>
            <div class="fieldset">
              <label for="nUndKat">Namen der Unter-Kategorien anlegen (diese bitte mit Komma getrennt)</label>
              <input type="text" name="newUkat" id="nUndKat" placeholder="Geben Sie die Namen der Unter-Kategorien an...(z.B.: Damen-Mode, Herren-Mode,...)" />
            </div>
            <div class="fieldset">
            <div class="btn-int-admin" onclick="createNewTopKat()">Jetzt erstellen</div>
            </div>
            </div>

          </div>
          ';
          echo $ausgabe;
          exit();
        }
  }
}
?>
