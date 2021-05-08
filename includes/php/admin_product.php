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
            $list.='<div id="TopTabedit'.$value->id.'" class="existing-sub-rows" style="height:3.5em;"><a><div style="display:inline-block;float:left;margin-left:0.3em;width:4em;height:3.5em;background-size:100% 100%;background-position:center;background-repeat:none;background-image:url(\'img/products/'.$imgsrc.'\')"></div> '.$value->name.'</a> | <span>Art-Nr:15454-'.$wert.'</span><i onclick="deleteProduct()" class="fas fa-trash-alt"></i><i onclick="changeProductSettings()" class="fas fa-edit"></i><i onclick="copyProductFull" class="far fa-copy"></i></div>';
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
            <input type="text" id="filterOnNameArtNr" placeholder="Produkt suchen (Name oder Artikel-Nr)"/>
            <select id="filterOnKat" style="margin-top:0.5em;"><option value="n">Kategorie anzeigen</option></select>
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
                          <div class="fieldset"><div class="btn-int-admin" onclick="saveVarianten()">Speichern und weiter >></div></div>
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
          if($ProdOBJ->updateProduct('product', htmlspecialchars(Session::get('wpid')), array('	variable_arr' => json_encode($garr)))!=TRUE){
            print 'NO';
            exit();
          }else{

            print 'OK';
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
