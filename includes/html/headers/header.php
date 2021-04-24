<div class="head-cointainer">
<img  onclick="reDirect('index.php')" class="logo" src="img/logo.png" alt="Logo" titel="logo">
<div class="mymenu">
  <span class="material-icons">account_circle</span>
</div>
</div>
<div class="hover-mymenu">
  <div class="hover-mymenu-innerdiv">
    <div class="rowspan-mymenu" onclick="reDirect('warenkorb.php')">
      <i class="fas fa-shopping-cart"></i> Warenkorb
    </div>
    <?php print($connectbtns.$loggedinbtns);?>
  </div>
</div>
<div id="slider" class="slider">
  <div class="inner-slider">
    <div class="inner-left-slider">

    </div>
    <div class="inner-right-slider">

    </div>
  </div>
</div>
<div class="search-menu">

  <div class="kat-menu">
    <div class="kat-menu-btn">
      Kategorien
      <div class="kat-menu-hover">
        <?php
        $CatOBJ=new Category();
        if($CatOBJ->getKat()){
          foreach ($CatOBJ->getKat() as $value) {
            if(file_exists('img/'.$value->top_kat_img)){

              $catStyle='background:url(\'img/'.$value->top_kat_img.'\');background-size: 80%;background-position: center center;background-repeat: no-repeat;';
            }else{
              $catStyle='';
            }
            if($value->top_kat_icon!=='a' &&(!empty(trim($value->top_kat_icon)))){
              $catIcon=$value->top_kat_icon;
            }else{
              $catIcon='';
            }
            echo '<div style="'.$catStyle.'" class="kat-listing">
              <h4>'.$catIcon.$value->top_kat.'</h4>';
              $arr=json_decode($value->und_kat);
              foreach($arr as $undkat){
                echo '<a>'.$undkat.'</a>';
              }
            echo '</div>';
          }
        }
        ?>
      </div>
    </div>
  </div>
  <div class="search-tab">
    <form id="search" action="search.php" method="post">
      <label for="searchCategory">Suche in</label>
      <select name="searchCategory">
        <option value="">Alle Kategorien</option>
      </select>
      <input type="text" name="searchValue" placeholder="Wonach suchst Du?...">
      <button form="search">Finden</button>
    </form>
  </div>

</div>
