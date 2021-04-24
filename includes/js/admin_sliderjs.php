<script type="text/javascript">
function editSlide(){
  $(function(){
    $.post( "includes/php/admin_slides.php", {
      Ausgabe : '1'
    }, function(data) {
        $( '.r-tab').html(data);
    });
  });
}
function updateSlideField(arr){
  $(function(){
    var str = arr;
    var res = str.split('_');
    var inpValue=$( '#'+res[0]+res[1] ).val();
    $.post( "includes/php/admin_slides.php", {
      inpType : arr,
      inpValue : inpValue
    }, function(data) {
      if(data=="NO"){
        $( '#'+res[0]+res[1] ).css('background','rgba(255,0,0,0.1)');

      }else{
        $( '#'+res[0]+res[1] ).css('background','rgba(0,255,0,0.1)');
        setTimeout(function(){
          $( '#'+res[0]+res[1] ).css('background','rgba(255,255,255,0.05)');
        }, 1000);
      }
    });
  });
}
function previewSlide(el){
  $(function(){
    var str = el;
    var res = str.split('.');
    const preview = document.getElementById('admin'+res[0]);
    const file = document.getElementById(res[0]).files[0];;
    const reader = new FileReader();
    reader.addEventListener("load", function () {
      // convert image file to base64 string
      preview.src = reader.result;
    }, false);

    if (file) {
      reader.readAsDataURL(file);
    }
  });
}
function progressHandler(event) {
  $(function(){
      var percent = (event.loaded / event.total) * 100;
      $( '#progressBar' ).val(Math.round(percent));
  });
}

function completeHandler(event) {
  $(function(){
    console.log(event.target.responseText);
    if(event.target.responseText=="NO"){
      $( '#filemsg' ).html('Hochladen fehlgeschlagen');
    }else if(event.target.responseText=="ERROR"){
      $( '#filemsg' ).html('ERROR: Bitte wählen Sie eine Datei aus.');
    }else{
      $( '#filemsg' ).html(event.target.responseText+' wurde hochgeladen');
      previewSlide(event.target.responseText)
    }
      setTimeout(function(){
        $( '#progressBar' ).val('0');
        $( '#filemsg' ).html('');
      }, 3000);
  });
}

function errorHandler(event) {
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

function abortHandler(event) {
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
function uploadFile(type) {
var file = document.getElementById(type).files[0];
// alert(file.name+" | "+file.size+" | "+file.type);
var formdata = new FormData();
formdata.append(type, file);
formdata.append("typ", type);
var ajax = new XMLHttpRequest();
ajax.upload.addEventListener("progress", progressHandler, false);
ajax.addEventListener("load", completeHandler, false);
ajax.addEventListener("error", errorHandler, false);
ajax.addEventListener("abort", abortHandler, false);
ajax.open("POST", "includes/php/admin_slides.php");
ajax.send(formdata);
setTimeout(function(){
  document.getElementById(type).value='';
}, 2000);
}
</script>
