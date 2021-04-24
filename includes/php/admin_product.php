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
        Ausgabe des HTML
        */
        if(Input::get('Ausgabe')){
          if($CatOBJ->getKat()){
            $select='<option >Auswählen</option>';
            $list='';
          foreach ($CatOBJ->getKat() as $value) {
            $select.='<option style="color:#000000;" value="'.$value->id.'">'.$value->top_kat.'</option>';
            $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows"><a>Artikelname</a> | <span>Art-Nr:15454155715</span><i onclick="leteTopkat(\''.$value->id.'\')" class="fas fa-trash-alt"></i><i class="fas fa-edit"></i></div>';
          }

          }else{

              $select='
                    <option style="color:#000000;" >Auswählen</option>
              ';

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

                    //Festpreis
                    if($ProdOBJ->createProduct('product',array(
                      'kat_id' => json_encode(Session::get('wTKat')),
                      'undKat_id' => json_encode(Session::get('wUKat')),
                      'name' => htmlspecialchars(Input::get('pname')),
                      'p_type' => htmlspecialchars(Input::get('pformat')),
                      'o_type' => htmlspecialchars(Input::get('preisformat')),
                      'price' => htmlspecialchars(Input::get('preis')),
                      'newprice' => htmlspecialchars(Input::get('uvppreis')),
                      'rabattprice' => htmlspecialchars(Input::get('angebotpreis'))
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
                    if($ProdOBJ->createProduct('product',array(
                      'kat_id' => json_encode(Session::get('wTKat')),
                      'undKat_id' => json_encode(Session::get('wUKat')),
                      'name' => htmlspecialchars(Input::get('pname')),
                      'p_type' => htmlspecialchars(Input::get('pformat')),
                      'o_type' => htmlspecialchars(Input::get('preisformat')),
                      'price' => htmlspecialchars(Input::get('preis')),
                      'dbuy' => $dbuy,
                      'dpreis' => htmlspecialchars(Input::get('direktpreis')),
                      'auction_time' => htmlspecialchars(Input::get('auctime'))
                    ))!=TRUE){
                      $ausgabe='NO';
                    } $button=$ProdOBJ->lastinsert();

              }

          }else{

              //Variables Produkt
              if($ProdOBJ->createProduct('product',array(
                'kat_id' => json_encode(Session::get('wTKat')),
                'undKat_id' => json_encode(Session::get('wUKat')),
                'name' => htmlspecialchars(Input::get('pname')),
                'p_type' => htmlspecialchars(Input::get('pformat')),
                'o_type' => htmlspecialchars(Input::get('preisformat')),
                'price' => htmlspecialchars(Input::get('preis')),
                'newprice' => htmlspecialchars(Input::get('uvppreis')),
                'rabattprice' => htmlspecialchars(Input::get('angebotpreis'))
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
        if(Input::get('tProduktEigenschaften')){

          if($ProdOBJ->updateProduct('product',htmlspecialchars(Session::get('wpid')),array('describing' => htmlspecialchars(Input::get('tProduktEigenschaften'))))!=TRUE){
            print 'NO';
            exit();
          }
          $ausgabe='
          <div class="flexi-show">
            <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
            <p>Legen Sie Die Eigenschaften Ihres Produktes fest. Wenn der Kunde Möglichkeit der Auswahl haben sollte, dann können Sie diese hier festlegen.</p>
            <div class="branding-name">Produkt-Eigenschaften</div>
            <div class="fieldset">
            <select id="seltypeigenschaft"><option value="n">Benutzerdefiniert</option></select>
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
          if($b>0){
            $x=0;
            $full_arr=array();

            foreach(Input::get('savePEigenschafteninps') as $value){
              $remember = (Input::get('savePEigenschaftencheck')[$x]==='on') ? true : false;
              $nameEig=explode(':', $value);
              $arrkey=$nameEig[0];
              $variant=explode(',',$nameEig[1]);
              $e_arr=array();
              foreach($variant as $b){
                if(!trim($b)){

                }else{
                  array_push($e_arr, $b);
                }
              }
              $innarr=array($arrkey => $e_arr);
              array_push($full_arr, $innarr);
              if($remember == true){
                if($ProdOBJ->getProdukt('p_eigenschaften',$nameEig[0])!=TRUE){
                  $ProdOBJ->createProduct('p_eigenschaften',array('name'=>$nameEig[0],'e_arr'=>json_encode($e_arr)));
                }
              }
            }
            if($ProdOBJ->updateProduct('product', htmlspecialchars(Session::get('wpid')), array('eigenschaften' => json_encode($full_arr)))!=TRUE){
              print 'NO';
              exit();
            }else{
              $ausgabe='
              <div class="flexi-show">
                <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
                <p>Legen Sie fest, ob der Preis besteuerbar ist.</p>
                <div class="branding-name">Besteuerbar</div>
                <div class="fieldset">
                <select ><option value="j">Besteuerbar</option><option value="n">nicht Besteuerbar</option></select>
                </div>
                <p>Legen Sie fest in welche Länder Sie das Produkt versenden möchten.</p>
                <div class="branding-name">Länder für Versand</div>
                <div class="fieldset">
                <select ><option value="DE">Deutschland</option><option value="BE">Belgien</option></select>
                </div>
                <p>Legen Sie die Lagermenge fest.</p>
                <div class="branding-name">Anzahl im Lagerbestand</div>
                <div class="fieldset">
                <input type="text" id="Lagerbestand" placeholder="Geben Sie den Lagerbestand des Produktes an">
                </div>
                <p>Geben Sie das Gewicht des Produktes an in Kg Zahl (z.B: 0.500kg).</p>
                <div class="branding-name">Produkt Gewicht</div>
                <div class="fieldset">
                <input type="text" id="ProduktGewicht" placeholder="Geben Sie das Gewicht des Produktes an">
                </div>
                <p>Geben Sie die Maßen des Produktes an im folgenden Muster(BxHxT).</p>
                <div class="branding-name">Produkt Maßen</div>
                <div class="fieldset">
                <input type="text" id="ProduktMasen" placeholder="Geben Sie die Maßen des Produktes an">
                </div>
                <p>Geben Sie Tag-Wörter für Ihr Produkt an. Diese dienen der Suchmaschinen-Optimierung</p>
                <div class="branding-name">Tag-Wörter</div>
                <div class="fieldset">
                <textarea id="ProduktTags" placeholder="Geben Sie die Tag-Wörter mit Komma getrennt an..."></textarea>
                </div>
                <div class="fieldset"><div class="btn-int-admin" onclick="savelastsettProd()">Speichern und weiter >></div></div>
              </div>
              ';

              print($ausgabe);
              exit();
            }
          }else{
            $ausgabe='
            <div class="flexi-show">
              <h3><i class="fas fa-hotdog"></i> Produkte</h3><hr>
              <p>Legen Sie fest, ob der Preis besteuerbar ist.</p>
              <div class="branding-name">Besteuerbar</div>
              <div class="fieldset">
              <select ><option value="j">Besteuerbar</option><option value="n">nicht Besteuerbar</option></select>
              </div>
              <p>Legen Sie fest in welche Länder Sie das Produkt versenden möchten.</p>
              <div class="branding-name">Länder für Versand</div>
              <div class="fieldset">
              <select ><option value="DE">Deutschland</option><option value="BE">Belgien</option></select>
              </div>
              <p>Legen Sie die Lagermenge fest.</p>
              <div class="branding-name">Anzahl im Lagerbestand</div>
              <div class="fieldset">
              <input type="text" id="Lagerbestand" placeholder="Geben Sie den Lagerbestand des Produktes an">
              </div>
              <p>Geben Sie das Gewicht des Produktes an in Kg Zahl (z.B: 0.500kg).</p>
              <div class="branding-name">Produkt Gewicht</div>
              <div class="fieldset">
              <input type="text" id="ProduktGewicht" placeholder="Geben Sie das Gewicht des Produktes an">
              </div>
              <p>Geben Sie die Maßen des Produktes an im folgenden Muster(BxHxT).</p>
              <div class="branding-name">Produkt Maßen</div>
              <div class="fieldset">
              <input type="text" id="ProduktMasen" placeholder="Geben Sie die Maßen des Produktes an">
              </div>
              <p>Geben Sie Tag-Wörter für Ihr Produkt an. Diese dienen der Suchmaschinen-Optimierung</p>
              <div class="branding-name">Tag-Wörter</div>
              <div class="fieldset">
              <textarea id="ProduktTags" placeholder="Geben Sie die Tag-Wörter mit Komma getrennt an..."></textarea>
              </div>
              <div class="fieldset"><div class="btn-int-admin" onclick="savelastsettProd()">Speichern und weiter >></div></div>
            </div>
            ';

            print($ausgabe);
            exit();
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
