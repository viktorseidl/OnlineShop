<?php
include 'globals.php'
$user= new User();
if($user->hasPermission('admin')){
  if(Input::exists()){
      $SlideOBJ=new Slideshow();
      $type=Input::get('typ');
      if (isset($_FILES[$type]["tmp_name"])) { // if file not chosen
            $fileName = $_FILES[$type]["name"]; // The file name
            $fileTmpLoc = $_FILES[$type]["tmp_name"]; // File in the PHP tmp folder
            $fileType = $_FILES[$type]["type"]; // The type of file it is
            $fileSize = $_FILES[$type]["size"]; // File size in bytes
            $fileErrorMsg = $_FILES[$type]["error"]; // 0 for false... and 1 for true
              if(Input::get('typ')){
                    $pimg_extention= explode(".", $fileName);
                    $pimg_extention= end($pimg_extention);
                    $fileName=Input::get('typ').'.'.$pimg_extention;
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
}
?>
