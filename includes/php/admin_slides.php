<?php
include 'globals.php';
$user= new User();
if($user->hasPermission('admin')){
  if(Input::exists()){
      $SlideOBJ=new Slideshow();
          /*
          Image Upload Slider
          */
          if(Input::get('typ')){
          $type=Input::get('typ');
          if (isset($_FILES[$type]["tmp_name"])) {
                $fileName = $_FILES[$type]["name"];
                $fileTmpLoc = $_FILES[$type]["tmp_name"];
                $fileType = $_FILES[$type]["type"];
                $fileSize = $_FILES[$type]["size"];
                $fileErrorMsg = $_FILES[$type]["error"];
                  if(Input::get('typ')){
                        $extention= explode(".", $fileName);
                        $extention= end($extention);
                        $fileName=Input::get('typ').'.'.$extention;
                  }

                if(move_uploaded_file($fileTmpLoc, "../../img/$fileName")){
                    if($SlideOBJ->updateSlide(htmlspecialchars(Input::get('typ')), array('slide_img' => $fileName))!=True){
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
        Onchange update Slide Info
        */
        if(Input::get('inpType')&&(Input::get('inpValue'))){
          $inpTypeArr=Input::get('inpType');
          $inpTypeArr=explode('_', $inpTypeArr);
          //Check kind of input
          switch ($inpTypeArr[0]) {
            case 'tl':
            $fields=array('l_text' => htmlspecialchars(Input::get('inpValue')));
            break;
            case 'tr':
            $fields=array('r_text' => htmlspecialchars(Input::get('inpValue')));
            break;
            case 'tbtn':
            $fields=array('btn_text' => htmlspecialchars(Input::get('inpValue')));
            break;
            case 'tv':
            $fields=array('btn_red' => htmlspecialchars(Input::get('inpValue')));
            break;
            default:
              $fields='';
              break;
          }

          if(is_array($fields)){
            $name="slider_".$inpTypeArr[1];
            if($SlideOBJ->updateSlide(htmlspecialchars($name), $fields)!=True){
                  echo "NO";
                  exit();
            }else{
                  echo 'OK';
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
        if(Input::get('Ausgabe')){
          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-calendar-week"></i> Slider</h3><hr>
            <p>Hier haben Sie die Möglichkeit, die Event-Ausgabe Einstellungen der Slider festzulegen.</p>
            <div class="branding-name">Slider 1</div>
            <div class="fieldset">
              <label for="tl1">Text Links</label>
              <textarea name="tl1" id="tl1" maxlength="500" onchange="updateSlideField(\'tl_1\')" placeholder="Text Links Slider 1... max 500 Zeichen" >'.$SlideOBJ->getSlide("slider_1")->l_text.'</textarea>
            </div>
            <div class="fieldset">
              <label for="tr1">Text Rechts (max 255 Zeichen)</label>
              <textarea name="tr1" id="tr1" maxlength="255" onchange="updateSlideField(\'tr_1\')" placeholder="Text Rechts Slider 1... max 255 Zeichen" >'.$SlideOBJ->getSlide("slider_1")->r_text.'</textarea>
            </div>
            <div class="fieldset">
              <label for="tbtn1">Text Button</label>
              <input type="text" name="tbtn1" id="tbtn1" value="'.$SlideOBJ->getSlide("slider_1")->btn_text.'" onchange="updateSlideField(\'tbtn_1\')" maxlength="30" placeholder="Text Button Slider 1..." />
            </div>
            <div class="fieldset">
              <label for="tv1">Verlinkung</label>
              <input type="text" name="tv1" id="tv1" value="'.$SlideOBJ->getSlide("slider_1")->btn_red.'" onchange="updateSlideField(\'tv_1\')" maxlength="50" placeholder="Verlinkung Slider 1..." />
            </div>
            <div class="branding-name">Slider 2</div>
            <div class="fieldset">
              <label for="tl2">Text Links</label>
              <textarea name="tl2" id="tl2" maxlength="500" onchange="updateSlideField(\'tl_2\')" placeholder="Text Links Slider 2... max 500 Zeichen" >'.$SlideOBJ->getSlide("slider_2")->l_text.'</textarea>
            </div>
            <div class="fieldset">
              <label for="tr2">Text Rechts (max 255 Zeichen)</label>
              <textarea name="tr2" id="tr2" maxlength="255" onchange="updateSlideField(\'tr_2\')" placeholder="Text Rechts Slider 2... max 255 Zeichen" >'.$SlideOBJ->getSlide("slider_2")->r_text.'</textarea>
            </div>
            <div class="fieldset">
              <label for="tbtn2">Text Button</label>
              <input type="text" name="tbtn2" id="tbtn2" value="'.$SlideOBJ->getSlide("slider_2")->btn_text.'" onchange="updateSlideField(\'tbtn_2\')" maxlength="30" placeholder="Text Button Slider 2..." />
            </div>
            <div class="fieldset">
              <label for="tv2">Verlinkung</label>
              <input type="text" name="tv2" id="tv2" value="'.$SlideOBJ->getSlide("slider_2")->btn_red.'" onchange="updateSlideField(\'tv_2\')" maxlength="50" placeholder="Verlinkung Slider 2..." />
            </div>
            <div class="branding-name">Slider 3</div>
            <div class="fieldset">
              <label for="tl3">Text Links</label>
              <textarea name="tl3" id="tl3" maxlength="500" onchange="updateSlideField(\'tl_3\')" placeholder="Text Links Slider 3... max 500 Zeichen" >'.$SlideOBJ->getSlide("slider_3")->l_text.'</textarea>
            </div>
            <div class="fieldset">
              <label for="tr3">Text Rechts (max 255 Zeichen)</label>
              <textarea name="tr3" id="tr3" maxlength="255" onchange="updateSlideField(\'tr_3\')" placeholder="Text Rechts Slider 3... max 255 Zeichen" >'.$SlideOBJ->getSlide("slider_3")->r_text.'</textarea>
            </div>
            <div class="fieldset">
              <label for="tbtn3">Text Button</label>
              <input type="text" name="tbtn3" id="tbtn3" value="'.$SlideOBJ->getSlide("slider_3")->btn_text.'" onchange="updateSlideField(\'tbtn_3\')" maxlength="30" placeholder="Text Button Slider 3..." />
            </div>
            <div class="fieldset">
              <label for="tv3">Verlinkung</label>
              <input type="text" name="tv3" id="tv3" value="'.$SlideOBJ->getSlide("slider_3")->btn_red.'" onchange="updateSlideField(\'tv_3\')" maxlength="50" placeholder="Verlinkung Slider 3..." />
            </div>
            <div class="branding-name">Fotos aktualisieren</div>
            <div class="fieldset">
            <form id="upload_form" enctype="multipart/form-data" method="post">
              <label>Slider 1</label>
              <img id="adminslider_1" src="img/'.$SlideOBJ->getSlide("slider_1")->slide_img.'" />
              <input type="file" name="slider_1" id="slider_1" onchange="uploadFile(\'slider_1\')"><br>
              <label>Slider 2</label>
              <img id="adminslider_2" src="img/'.$SlideOBJ->getSlide("slider_2")->slide_img.'" />
              <input type="file" name="slider_2" id="slider_2" onchange="uploadFile(\'slider_2\')"><br>
              <label>Slider 3</label>
              <img id="adminslider_3" src="img/'.$SlideOBJ->getSlide("slider_3")->slide_img.'" />
              <input type="file" name="slider_3" id="slider_3" onchange="uploadFile(\'slider_3\')"><br>
              <progress id="progressBar" value="0" max="100"></progress><br>
              <span id="filemsg"></span>
            </form>
            </div>
          </div>
          ';
          echo $ausgabe;
          exit();
        }
  }
}
?>
