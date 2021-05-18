<script type="text/javascript">


function Taxes(){
  $(function(){
    $.post( "includes/php/admin_tax.php", {
      Ausgabe : '1'
    }, function(data) {
        $( '.r-tab').html(data);
    });
  });
}
function addNewTax(){
  $(function(){
    var country=$('#country').val();
    var tax=$('#prozentTax').val();
    var shipping=$('#VersandTax').val();
    if(country && tax && shipping){
        $.post( "includes/php/admin_tax.php", {
          addNewTax : country+':'+tax+':'+shipping
        }, function(data) {
            if(data=='OK'){
              Taxes();
            }
        });
    }
  });
}
function deleteTaxes(key){
  $(function(){
        $.post( "includes/php/admin_tax.php", {
          deleteTaxeskey : key,
          deleteTaxes : '1'
        }, function(data) {
          console.log(data);
            if(data=='OK'){
              Taxes();
            }
        });

  });
}
</script>
