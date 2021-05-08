<script type="text/javascript">
function editKategory(){
  $(function(){
    $.post( "includes/php/admin_kategory.php", {
      Ausgabe : '1'
    }, function(data) {
        $( '.r-tab').html(data);
    });
  });
}
function createNewTopKat(){
  $(function(){
    var inpValue1=$( '#nTopKat').val();
    var inpValue2=$( '#nUndKat').val();
    $.post( "includes/php/admin_kategory.php", {
      nTopKat : inpValue1,
      nUndKat : inpValue2
    }, function(data) {
      if(data=="NO"){

      }else{
        $( '#nTopKat').css('background','rgba(0,255,0,0.1)');
        $( '#nUndKat').css('background','rgba(0,255,0,0.1)');
        reloadEditKat();
        updateTopKatlist();
        setTimeout(function(){
          $( '#nTopKat').val('');
          $( '#nUndKat').val('');
          $( '#nTopKat').css('background','rgba(255,255,255,0.05)');
          $( '#nUndKat').css('background','rgba(255,255,255,0.05)');
        }, 1000);
      }
    });
  });
}
function reloadEditKat(){
  $(function(){
    $.post( "includes/php/admin_kategory.php", {
      reloadEditKat : '1'
    }, function(data) {
        $( '.editing-div-loader1').html(data);

    });
  });
}
function updateTopKatlist(){
  $(function(){
    $.post( "includes/php/admin_kategory.php", {
      updateTopKatlist : '1'
    }, function(data) {
        $( '#TopkastListdiv').html(data);

    });
  });
}
function loadEditKat(){
  $(function(){
    var inpValue1=$( '#eTopKat').val();
    $.post( "includes/php/admin_kategory.php", {
      EditKat : inpValue1
    }, function(data) {
        $( '.editing-div-loader1').html(data);

    });
  });
}
function refreshUkats(kat){
  $(function(){
    $.post( "includes/php/admin_kategory.php", {
      refreshUkats : kat
    }, function(data) {
        $( '#UndKatslistdiv').html(data);
    });
  });
}
function leteUnderkat(key,kat){
  $(function(){
    $.post( "includes/php/admin_kategory.php", {
      lUKat_key : key,
      lUKat_kat : kat
    }, function(data) {
        if(data=="OK"){
          $('#UnTabedit'+key).toggle();
        }
    });
  });
}
function deleteBKTLogo(kat){
  $(function(){
    $.post( "includes/php/admin_kategory.php", {
      deleteBKTLogo : kat
    }, function(data) {
        if(data=="OK"){
          $( '#admin-katlogo').attr('src','img/pholder.png');
        }
    });
  });
}
function leteTopkat(kat){
  $(function(){
    $.post( "includes/php/admin_kategory.php", {
      leteTopkat : kat
    }, function(data) {
        if(data=="OK"){
          $( '#TopTabedit'+kat).css('display','none');
        }
    });
  });
}
function saveKatsEdit(type,kat){
  $(function(){
    if(type=="i"){
      var inpValue1=$( '#nTopKatIcon').val();
      var el="nTopKatIcon";
    }else{
      var inpValue1=$( '#newUKat').val();
      var el="newUKat";
    }

    $.post( "includes/php/admin_kategory.php", {
      sKE_typ : type,
      sKE_kat : kat,
      sKE_inp : inpValue1
    }, function(data) {

      if(type=="i"){
        $( '#nTopKatIcon').css('background','rgba(0,255,0,0.1)');
        setTimeout(function(){
          $( '#nTopKatIcon').css('background','rgba(255,255,255,0.05)');
        }, 1000);
      }else{
        $( '#newUKat').css('background','rgba(0,255,0,0.1)');
        refreshUkats(kat);
        setTimeout(function(){
          $( '#newUKat').val('');
          $( '#newUKat').css('background','rgba(255,255,255,0.05)');
        }, 1000);
      }


    });
  });
}
function previewSlideK(){
  $(function(){

    const preview = document.getElementById('admin-katlogo');
    const file = document.getElementById('slider_1').files[0];;
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
function progressHandlerK(event) {
  $(function(){
      var percent = (event.loaded / event.total) * 100;
      $( '#progressBar' ).val(Math.round(percent));
  });
}

function completeHandlerK(event) {
  $(function(){
    console.log(event.target.responseText);
    if(event.target.responseText=="NO"){
      $( '#filemsg' ).html('Hochladen fehlgeschlagen');
    }else if(event.target.responseText=="ERROR"){
      $( '#filemsg' ).html('ERROR: Bitte wählen Sie eine Datei aus.');
    }else{
      $( '#filemsg' ).html(event.target.responseText+' wurde hochgeladen');
      previewSlideK();
    }
      setTimeout(function(){
        $( '#progressBar' ).val('0');
        $( '#filemsg' ).html('');
      }, 3000);
  });
}

function errorHandlerK(event) {
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

function abortHandlerK(event) {
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
function uploadFileK(type,kat) {
var file = document.getElementById(type).files[0];
// alert(file.name+" | "+file.size+" | "+file.type);
var formdata = new FormData();
formdata.append(type, file);
formdata.append("typ", type);
formdata.append("kat", kat);
var ajax = new XMLHttpRequest();
ajax.upload.addEventListener("progress", progressHandlerK, false);
ajax.addEventListener("load", completeHandlerK, false);
ajax.addEventListener("error", errorHandlerK, false);
ajax.addEventListener("abort", abortHandlerK, false);
ajax.open("POST", "includes/php/admin_kategory.php");
ajax.send(formdata);
setTimeout(function(){
  document.getElementById(type).value='';
}, 2000);
}
</script>
