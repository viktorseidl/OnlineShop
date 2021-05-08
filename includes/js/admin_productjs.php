<script type="text/javascript">
function editProduct(){
  $(function(){
    $.post( "includes/php/admin_product.php", {
      Ausgabe : '1'
    }, function(data) {
        $( '.r-tab').html(data);
    });
  });
}
function createNewProduct(){
  $(function(){
    $.post( "includes/php/admin_product.php", {
      new : '1'
    }, function(data) {
        $( '.r-tab').html(data);
    });
  });
}
function saveStepOne(){

  $(function(){
    var inpValue1=$('input[name="Kats[]"]:checked').map(function(){
                    return this.value;
                  }).get();
    var check=0;
    inpValue1.forEach(element => check=Number(check)+Number(element));
    if(check > 0){
    $.post( "includes/php/admin_product.php", {
      TKats : inpValue1
    }, function(data) {
      $( '.r-tab').html(data);
    });
    }else{
    alert('Sie müssen mindestens eine Kategorie auswählen!');
    }
  });
}
function saveStepTwo(){
  var chek=0;
  $(function(){
    var inpValue1=$('input[name="UndKats[]"]:checked').map(function(){
                    if(this.checked==true){
                      chek=Number(chek)+Number(1)
                    }
                    return this.value;
                  }).get();

    if(chek>0){
        $.post( "includes/php/admin_product.php", {
          UKats : inpValue1
        }, function(data) {

          $( '.r-tab').html(data);
        });
    }else{
      alert('Sie müssen mindestens eine Unter-Kategorie auswählen!');
    }
  });
}
function getPriceForm(){
  $(function(){
    var inpValue1=$('#PFormat').val();
    if(inpValue1==1){
      $( '#div-PreisFormat').css('display','block');
      $('#p-PreisFormat').html('Einfache Produkte können zum Festpreis oder zum Auktions-Preis angeboten werden. Bitte wählen Sie das Preis-Format aus.');
      $('#PreisFormat').html('<option value="1">Festpreis</option><option value="2">Auktion</option>');
      $('#div-Preis').html('<p>Bitte geben Sie den Verkaufspreis des Produktes an.</p><div class="branding-name">Preis</div><div class="fieldset"><input type="text" name="preis" id="preis" placeholder="Geben Sie den Preis für das Produkt an" /></div><p>Hier können Sie eine unverbindliche Preis-Empfehlung angeben.</p><div class="branding-name">UVP-Preis</div><div class="fieldset"><input type="text" name="npreis" id="npreis" placeholder="Geben Sie den UVP-Preis für das Produkt an" /></div><p>Sollte der Preis des Produktes sich vom aktuellen Preis reduziert haben, dann geben Sie diesen Bitte hier an.</p><div class="branding-name">Angebots-Preis</div><div class="fieldset"><input type="text" name="apreis" id="apreis" placeholder="Geben Sie den Angebots-Preis für das Produkt an" /></div><div class="fieldset"><div class="btn-int-admin" onclick="saveStepThree()">Speichern und weiter >></div></div>');
    }else if(inpValue1==2){
      $( '#div-PreisFormat').css('display','block');
      $('#p-PreisFormat').html('Für variable Produkte, steht lediglich das Festpreis-Format zur Verfügung. Wenn der Preis auf alle Varianten gleich ist, können Sie diesen hier festlegen.');
      $('#PreisFormat').html('<option value="1">Festpreis</option>');
      $('#div-Preis').html('<p>Bitte geben Sie den Verkaufspreis des Produktes an.</p><div class="branding-name">Preis</div><div class="fieldset"><input type="text" name="preis" id="preis" placeholder="Geben Sie den Preis für das Produkt an" /></div><p>Hier können Sie eine unverbindliche Preis-Empfehlung angeben.</p><div class="branding-name">UVP-Preis</div><div class="fieldset"><input type="text" name="npreis" id="npreis" placeholder="Geben Sie den UVP-Preis für das Produkt an" /></div><p>Sollte der Preis des Produktes sich vom aktuellen Preis reduziert haben, dann geben Sie diesen Bitte hier an.</p><div class="branding-name">Angebots-Preis</div><div class="fieldset"><input type="text" name="apreis" id="apreis" placeholder="Geben Sie den Angebots-Preis für das Produkt an" /></div><div class="fieldset"><div class="btn-int-admin" onclick="saveStepThree()">Speichern und weiter >></div></div>');
    }else{
      $( '#div-PreisFormat').css('display','none');
      $('#PreisFormat').html('');
      $('#div-Preis').html('');
    }
  });
}
function getPForm(){
  $(function(){
    var inpValue1=$('#PreisFormat').val();
    if(inpValue1==1){
      $('#div-Preis').html('<p>Bitte geben Sie den Verkaufspreis des Produktes an.</p><div class="branding-name">Preis</div><div class="fieldset"><input type="text" name="preis" id="preis" placeholder="Geben Sie den Preis für das Produkt an" /></div><p>Hier können Sie eine unverbindliche Preis-Empfehlung angeben.</p><div class="branding-name">UVP-Preis</div><div class="fieldset"><input type="text" name="npreis" id="npreis" placeholder="Geben Sie den UVP-Preis für das Produkt an" /></div><p>Sollte der Preis des Produktes sich vom aktuellen Preis reduziert haben, dann geben Sie diesen Bitte hier an.</p><div class="branding-name">Angebots-Preis</div><div class="fieldset"><input type="text" name="apreis" id="apreis" placeholder="Geben Sie den Angebots-Preis für das Produkt an" /></div><div class="fieldset"><div class="btn-int-admin" onclick="saveStepThree()">Speichern und weiter >></div></div>');
    }else if(inpValue1==2){
      $('#div-Preis').html('<p>Bitte geben Sie den Auktions-Preis des Produktes an.</p><div class="branding-name">Auktions-Preis</div><div class="fieldset"><input type="text" name="preis" id="preis" placeholder="Geben Sie den Auctions-Preis für das Produkt an" /></div><p>Hier können Sie einen Sofortkauf-Preis zusätzlich angeben.</p><div class="branding-name">Sofortkauf-Preis</div><div class="fieldset"><input type="text" name="dpreis" id="dpreis" placeholder="Geben Sie einen Sofortkauf-Preis für das Produkt an" /></div><p>Wählen Sie einen Auktions-Zeitraum aus.</p><div class="branding-name">Auktions-Zeitraum</div><div class="fieldset"><select name="auctime" id="auctime"><option value="5">5 Tage</option><option value="10">10 Tage</option><option value="15">15 Tage</option><option value="30">30 Tage</option></select></div><div class="fieldset"><div class="btn-int-admin" onclick="saveStepThree()">Speichern und weiter >></div></div>');
    }else{
      $('#PreisFormat').html('');
    }
  });
}

function saveStepThree(){

  $(function(){
    var pname=$('#pname').val();
    var pformat=$('#PFormat').val();
    var preisformat=$('#PreisFormat').val();
    if(pformat=='1'){
      if(preisformat=='1'){
            var preis=$('#preis').val();
            var uvppreis=$('#npreis').val();
            var angebotpreis=$('#apreis').val();
            $.post( "includes/php/admin_product.php", {
              pname : pname,
              pformat : pformat,
              preisformat : preisformat,
              preis : preis,
              uvppreis : uvppreis,
              angebotpreis : angebotpreis
            }, function(data) {
              $( '.r-tab').html(data);
            });
      }else{
            var auctionpreis=$('#preis').val();
            var direktpreis=$('#dpreis').val();
            var auctime=$('#auctime').val();
            $.post( "includes/php/admin_product.php", {
              pname : pname,
              pformat : pformat,
              preisformat : preisformat,
              preis : auctionpreis,
              direktpreis : direktpreis,
              auctime : auctime
            }, function(data) {
              $( '.r-tab').html(data);
            });
      }

    }else{
          var preis=$('#preis').val();
          var uvppreis=$('#npreis').val();
          var angebotpreis=$('#apreis').val();
          $.post( "includes/php/admin_product.php", {
            pname : pname,
            pformat : pformat,
            preisformat : preisformat,
            preis : preis,
            uvppreis : uvppreis,
            angebotpreis : angebotpreis
          }, function(data) {
            $( '.r-tab').html(data);
          });
    }
  });
}

function progressHandlerP(event) {
  $(function(){
      var percent = (event.loaded / event.total) * 100;
      $( '#progressBar' ).val(Math.round(percent));
  });
}

function completeHandlerP(event) {
  $(function(){

    if(event.target.responseText=="NO"){
      $( '#filemsg' ).html('Hochladen fehlgeschlagen');
    }else{
      $( '#filemsg' ).html('Bilder wurden hochgeladen');
      choosepicsuploaded(event.target.responseText);
    }
      setTimeout(function(){
        $( '#progressBar' ).val('0');
        $( '#filemsg' ).html('');
      }, 3000);
  });
}

function errorHandlerP(event) {
  $(function(){
    if(event.target.responseText=="NO"){
      $( '#filemsg' ).html('Hochladen fehlgeschlagen');
    }else if(event.target.responseText=="ERROR"){
      $( '#filemsg' ).html('ERROR: Bitte wählen Sie eine Datei aus.');
    }else{

    }
      setTimeout(function(){
        $( '#progressBar' ).val('0');
        $( '#filemsg' ).html('');
      }, 3000);
  });
}

function abortHandlerP(event) {
  $(function(){
    if(event.target.responseText=="NO"){
      $( '#filemsg' ).html('Hochladen fehlgeschlagen');
    }else if(event.target.responseText=="ERROR"){
      $( '#filemsg' ).html('ERROR: Bitte wählen Sie eine Datei aus.');
    }else{

    }
      setTimeout(function(){
        $( '#progressBar' ).val('0');
        $( '#filemsg' ).html('');
      }, 3000);
  });
}
function saveStepPFour(id) {
var file = document.getElementById("files").files;
if(file.length>0){
// alert(file.name+" | "+file.size+" | "+file.type);
var formdata = new FormData();

for(var i = 0; i < file.length; i++){
  formdata.append("file"+i, file[i]);
}

formdata.append("pid", id);
var ajax = new XMLHttpRequest();
ajax.upload.addEventListener("progress", progressHandlerP, false);
ajax.addEventListener("load", completeHandlerP, false);
ajax.addEventListener("error", errorHandlerP, false);
ajax.addEventListener("abort", abortHandlerP, false);
ajax.open("POST", "includes/php/admin_product.php");
ajax.send(formdata);
}else{
  alert('Bitte wählen Sie mindestens 1 Produkt-Bild aus!');
}
}
function choosepicsuploaded(pid){
  $(function(){
    $.post( "includes/php/admin_product.php", {
      choosegallerypic : pid
    }, function(data) {

      $( '.r-tab').html(data);
    });
  });
}
function setAsGallery(key){
  $(function(){
    $.post( "includes/php/admin_product.php", {
      makeitgallery : key
    }, function(data) {
      if(data=='NO'){

      }
      $( '#choosegalleryImgkey').html(data);

    });
  });
}
function letsdescripProduct(){
  $(function(){
    $.post( "includes/php/admin_product.php", {
      letsdescripProduct : 'asd'
    }, function(data) {
      $( '.r-tab').html(data);
    });
  });
}
function ProduktEigenschaften(){
  $(function(){
    var t= $('#Produkt-Beschreibung').val();
    if(!t){
      alert('Bitte legen Sie eine Produktbeschreibung fest');
    }else{
    $.post( "includes/php/admin_product.php", {
      tProduktEigenschaften : t
    }, function(data) {
      if(data=='NO'){

      }else{
        $( '.r-tab').html(data);
      }
    });
    }
  });
}
function TextVorschauBeschreibung(){
  $(function(){
    var t= $('#Produkt-Beschreibung').val();
    $.post( "includes/php/admin_product.php", {
      TextVorschauBeschreibung : t
    }, function(data) {

      if(data=='NO'){

      }else{
        $( '#TextVorschautab').html(data);
      }
    });
  });
}
function addeigenschaftsel(){
  $(function(){
    var t= $('#seltypeigenschaft').val();
    if(t=='n'){
      $( '#Eigenschaftenvorschautab').append('<div class="branding-name">Eigenschaft festlegen</div><p>Hier können Sie die Eigenschaft des Produktes festlegen. Benutzen Sie dafür folgende Syntax (NameEigenschaft:Variante,Variante,...)</p><div class="fieldset"><input type="text" name="peigenschaft" id="peigenschaft" placeholder="NameEigenschaft:Variante,Variante,..." /></div><div class="fieldset"><input type="checkbox" style="width:1em;height:1em;" name="peigenschaftcheck" id="peigenschaftcheck" /> Für zukünftige Produkte speichern?</div>');
    }else{
        $.post( "includes/php/admin_product.php", {
          addeigenschaftsel : t
        }, function(data) {
          if(data=='NO'){

          }else{
            $( '#Eigenschaftenvorschautab').append(data);
            $('#seltypeigenschaft').val('n');
          }
        });
    }
  });
}
function savePEigenschaften(){

  $(function(){
    var checkboxes=$('input[name="peigenschaftcheck"]').map(function(){
                  return this.checked;
                  }).get();
    var inps=$('input[name="peigenschaft"]').map(function(){
                    return this.value;
                  }).get();

    $.post( "includes/php/admin_product.php", {
      savePEigenschaften : 'hasa',
      savePEigenschaftencheck : checkboxes,
      savePEigenschafteninps : inps
    }, function(data) {

      $( '.r-tab').html(data);
    });
  });
}
function savelastsettProd(){

  $(function(){
      var steuer= $('#psteuer').val();
      var menge= $('#Lagerbestand').val();
      var gewicht= $('#pGewicht').val();
      var laenge= $('#plaenge').val();
      var breite= $('#pbreite').val();
      var hoehe= $('#phoch').val();
      var tagswords= $('#ProduktTags').val();
    $.post( "includes/php/admin_product.php", {
      steuer    : steuer,
      menge     : menge,
      gewicht   : gewicht,
      laenge    : laenge,
      breite    : breite,
      hoehe     : hoehe,
      tagswords : tagswords,
    }, function(data) {
      if(data=='OK'){
        editProduct();
      }else if(data=='NO'){

      }else{
        $( '.r-tab').html(data);
      }
    });
  });
}
function changeFImgV(key,eig,img,name){
  $(function(){
      var aktimg= $('.fimg'+eig+name).val();
      if(aktimg==key){

      }else{
        $('.fimg'+eig+name).val(key);
        $('.fimgsrc'+eig+name).val(img);
        $('#'+eig+aktimg+name).css('border-color', '#FFFFFF');
        $('#'+eig+key+name).css('border-color', '#00FF00');
      }

  });
}
function saveVarianten(){

  $(function(){
    var VNameKey=$('input[name="variablenamekey"]').map(function(){
                  return this.value;
                  }).get();
    var VFrontImg=$('input[name="frontimgonVSRC"]').map(function(){
                  return this.value;
                  }).get();
    var VProdPreis=$('input[name="VPpreis"]').map(function(){
                  return this.value;
                  }).get();
    var VPneupreis=$('input[name="VPneupreis"]').map(function(){
                  return this.value;
                  }).get();
    var VPdispreis=$('input[name="VPrabattpreis"]').map(function(){
                  return this.value;
                  }).get();
    var VPGewicht=$('input[name="VPgewicht"]').map(function(){
                  return this.value;
                  }).get();
    var VProdlong=$('input[name="VPlong"]').map(function(){
                  return this.value;
                  }).get();
    var VPBreite=$('input[name="VPbreite"]').map(function(){
                  return this.value;
                  }).get();
    var VPHohe=$('input[name="VPhohe"]').map(function(){
                  return this.value;
                  }).get();


    $.post( "includes/php/admin_product.php", {
      VNameKey : VNameKey,
      VFrontImg : VFrontImg,
      VProdPreis : VProdPreis,
      VPneupreis : VPneupreis,
      VPdispreis : VPdispreis,
      VPGewicht : VPGewicht,
      VProdlong : VProdlong,
      VPBreite : VPBreite,
      VPHohe : VPHohe
    }, function(data) {

      if(data=='OK'){
        editProduct();
      }else{

      }
    });
  });
}
function setintext(img){
    var p='[img]';
    var d='[/img]';
  var richTextField = document.getElementById('Produkt-Beschreibung');
  var TextField=richTextField.value;
  richTextField.value=TextField+p+img+d;

}
</script>
