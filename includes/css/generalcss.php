<style media="screen">
  body{
    margin: 0;
    padding: 0;
    font-family: arial, sans-serif;
    color:#FFFFFF;
    font-size: 1em;
  }
  .head-cointainer{
    position:fixed;
    z-index: 2000;
    width: 100%;
    background: rgba(0,0,0,0.95);
    border-bottom: 1px solid #333333;
    box-shadow: inset 0 -0.3em 0.3em rgba(255,255,225,0.2),inset 0 0.1em 0.1em rgba(255,255,225,0.15);
  }
  .logo{
    display: inline-block;
    float: left;
    width:4.5em;
    cursor: pointer;
    margin-top:0.8em;
    margin-bottom:0.5em;
    margin-left:2em;
    border-radius: 50%;
  }
  .mymenu{
    display: inline-block;
    float: right;
    background: #222222;
    color:#CCCCCC;
    margin-right:3em;
    border:1px solid #555555;
    cursor: pointer;
    line-height: 0.5em;
    border-radius: 50%;
    margin-top: 0.7em;
    text-align: center;
    float: right;
  }
  .mymenu:hover{
    display: inline-block;
    float: right;
    background: #111111;
    color:#FFFFFF;
    margin-right:3em;
    border:1px solid #555555;
    cursor: pointer;
    line-height: 0.5em;
    border-radius: 50%;
    margin-top: 0.7em;
    text-align: center;
    float: right;
  }
  .mymenu span{
    font-size: 3.5em;
    padding: 0.1em;
  }
  .hover-mymenu{
    position: fixed;
    display: none;
    right: 3em;
    top: 4em;
    background:#000000;
    z-index: 3000;
    border:1px solid rgba(140,140,35,0.7);
  }
  .hover-mymenu-innerdiv{
    display: inline-block;
    width:15em;
  }
  .rowspan-mymenu{
    display: inline-block;
    width:100%;
    background:rgba(255,255,255,0.07);
    padding-top:1em;
    padding-bottom:1em;
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
    box-shadow:inset 0 0.2em 0.2em rgba(255,255,255,0.2),inset 0 -0.3em 0.2em rgba(0,148,255,0.1);
    cursor: pointer;
  }
  .rowspan-mymenu:hover{
    background:#000000;
    box-shadow:inset 0 0.4em 0.4em rgba(255,255,255,0.2);
  }
  .rowspan-mymenu i{
    display: inline-block;
    float: left;
    margin-left: 2em;
  }
  ::-webkit-scrollbar {
    width: 8px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: #555555;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #222222;
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #111111;
  }
  .footer{
    display: inline-block;
    float: left;
    margin-top: 6em;
    width: 100%;
    background: rgba(0,0,0,0.95);
    border-top: 1px solid #333333;
    box-shadow: inset 0 0.3em 0.3em rgba(255,255,225,0.2),inset 0 -0.1em 0.1em rgba(255,255,225,0.15);
  }
  .slider{
    display: inline-block;
    width: 100%;
    height: 36em;
    text-align:center;
    background: url('img/<?php print($sliderObj->getSlide('slider_1')->slide_img); ?>');
    animation: mymove 35s infinite;
  }

  @keyframes mymove {
    10%   {background: url('img/<?php print($sliderObj->getSlide('slider_1')->slide_img); ?>');}
    45%  {background: url('img/<?php print($sliderObj->getSlide('slider_2')->slide_img); ?>');}
    70%  {background: url('img/<?php print($sliderObj->getSlide('slider_3')->slide_img); ?>');}
  }
  .inner-slider{
    display: inline-block;
    width:90%;
    margin-top:10em;
  }
  .inner-left-slider{
    display:inline-block;
    float: left;
    background:rgba(0,0,0,0.65);
    text-shadow:1px 1px black;
    font-size:1.5em;
    margin-left:5%;
    border-radius:0.2em;
    width:40%;
    text-align: left;
  }

  .inner-left-slider p{
    margin:1em;
  }
  .inner-right-slider{
    display:inline-block;
    float: right;
    text-align: left;
    margin-right:5%;
    width:40%;
  }
  .inner-right-slider p{
    width:65%;
    font-size:1.2em;
    margin-top: 3em;
    text-shadow:1px 1px black;
    background:rgba(0,0,0,0.65);
    border-radius:0.2em;
    padding:0.8em;
    display:inline-block;
  }
  .inner-right-slider hr{
    width:70%;
    float:left;
    clear:right;
    display:inline-block;
  }
  .inner-right-slider button{
    display: inline-block;
    clear:left;
    float:left;
    margin-top:1em;
    margin-left:2em;
    font-size:1.5em;
    padding:0.5em;
    padding-left:1em;
    padding-right:1em;
    font-weight: bold;
  }
  .search-menu{
    display: inline-block;
    width: 100%;
    background: rgba(0,0,0,0.95);
    border-bottom: 1px solid #333333;
    box-shadow: inset 0 -0.3em 0.3em rgba(255,255,225,0.2),inset 0 0.1em 0.1em rgba(255,255,225,0.15);
  }

  .kat-menu-btn{
    display: inline-block;
    width:100%;
    background:rgba(255,255,255,0.07);
    padding-top:1em;
    padding-bottom:1em;
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
    box-shadow:inset 0 0.2em 0.2em rgba(255,255,255,0.2),inset 0 -0.3em 0.2em rgba(0,148,255,0.1);
    cursor: pointer;
  }

  .kat-menu-hover{
    position: absolute;
    z-index: 1000;
    color:#000000;
    display: none;
    border:1px solid #333333;
    background: #FFFFFF;
    margin-left: 2em;
    margin-top: 0.5em;
    width: 45%;
  }
  .kat-listing{
    display: inline-block;
    float: left;
    width: 30%;
    height:12em;
    margin-left: 2.5%;

  }
  .kat-listing h4{
    display: inline-block;
    text-align: left;
    line-height: 0.7em;
    font-size: 1.2em;
    width: 90%;
  }
  .kat-listing i{
    margin-right:0.5em;
  }
  .kat-listing a{
    display: inline-block;
    text-align: left;
    font-weight: normal;
    text-decoration: underline;
    color: blue;
    width: 90%;
  }
  .kat-listing a:hover{
    display: inline-block;
    text-align: left;
    font-weight: normal;
    text-decoration: underline;
    color: light blue;
    width: 90%;
  }
  .search-tab{
    display: inline-block;
    width:74%;
    height: 1.5em;
  }
  .kat-menu{
    display: inline-block;
    width: 25%;
  }
  .search-tab label{
    display: inline-block;
    float: left;
    margin-left: 1.5em;
    margin-top: 0.4em;
    font-size:1.2em;
  }
  .search-tab select{
    display: inline-block;
    float: left;
    margin-left: 1.5em;
    font-size:1.2em;
    margin-top: 0.4em;
    width: 20%;
  }
  .search-tab input{
    display: inline-block;
    float: left;
    margin-left: 1.5em;
    font-size:1.2em;
    width: 40%;
    margin-top: 0.4em;
    outline: none;
  }
  .search-tab button{
    display: inline-block;
    float: left;
    margin-left: 1.5em;
    font-size:1.2em;
    width: 10%;
    margin-top: 0.4em;
    outline: none;
  }

  @media screen and (max-width: 500px) {
    .head-cointainer{
      position:fixed;
      z-index: 2000;
      width: 100%;
      background: rgba(0,0,0,0.95);
      border-bottom: 1px solid #333333;
      box-shadow: inset 0 -0.3em 0.3em rgba(255,255,225,0.2),inset 0 0.1em 0.1em rgba(255,255,225,0.15);
    }
    .logo{
      display: inline-block;
      float: left;
      width:2.5em;
      margin-top:0.8em;
      margin-bottom:0.5em;
      margin-left:1em;
      border-radius: 50%;
    }
    .mymenu{
      display: inline-block;
      float: right;
      background: #222222;
      color:#CCCCCC;
      margin-right:1em;
      border:1px solid #555555;
      cursor: pointer;
      line-height: 0.5em;
      border-radius: 50%;
      margin-top: 0.7em;
      text-align: center;
      float: right;
    }
    .mymenu:hover{
      display: inline-block;
      float: right;
      background: #111111;
      color:#FFFFFF;
      margin-right:1em;
      border:1px solid #555555;
      cursor: pointer;
      line-height: 0.5em;
      border-radius: 50%;
      margin-top: 0.7em;
      text-align: center;
      float: right;
    }
    .mymenu span{
      font-size: 2em;
      padding: 0.1em;
    }
    .hover-mymenu{
      position: fixed;
      right: 0;
      width: 60%;
      z-index: 1000;
      padding-top: 4em;
      top: 0;
      background:#000000;
      border:1px solid rgba(140,140,35,0.7);
    }
    .hover-mymenu-innerdiv{
      display: inline-block;
      width: 100%;
      text-align: center;
    }
    .rowspan-mymenu{
      display: inline-block;
      width:100%;
      background:rgba(255,255,255,0.07);
      padding-top:0.5em;
      padding-bottom:0.5em;
      font-size: 1.2em;
      font-weight: bold;
      text-align: center;
      box-shadow:inset 0 0.2em 0.2em rgba(255,255,255,0.2),inset 0 -0.3em 0.2em rgba(0,148,255,0.1);
      cursor: pointer;
    }
    .rowspan-mymenu:hover{
      background:#000000;
      box-shadow:inset 0 0.4em 0.4em rgba(255,255,255,0.2);
    }
    .rowspan-mymenu i{
      display: inline-block;
      float: left;
      margin-left: 3em;
    }
    .footer{
      display: inline-block;
      float: left;
      margin-top: 6em;
      width: 100%;
      background: rgba(0,0,0,0.95);
      border-top: 1px solid #333333;
      box-shadow: inset 0 0.3em 0.3em rgba(255,255,225,0.2),inset 0 -0.1em 0.1em rgba(255,255,225,0.15);
    }
    .slider{
      display: inline-block;
      width: 100%;
      height: 36em;
      text-align:center;
      background: url('img/slider_1.jpg');
      animation: mymove 35s infinite;
    }

    @keyframes mymove {
      10%   {background: url('img/slider_1.jpg');}
      45%  {background: url('img/slider_2.jpg');}
      70%  {background: url('img/slider_3.jpg');}
    }
    .inner-slider{
      display: inline-block;
      width:95%;
      margin-top:6em;
    }
    .inner-left-slider{
      display:inline-block;
      float: left;
      background:rgba(0,0,0,0.65);
      text-shadow:1px 1px black;
      font-size:1em;
      margin-left:0;
      border-radius:0.2em;
      width:100%;
      text-align: left;
    }

    .inner-left-slider p{
      margin:1em;
    }
    .inner-right-slider{
      display:inline-block;
      float: left;
      text-align: left;
      margin-right:0;
      width:100%;
    }
    .inner-right-slider p{
      width:75%;
      font-size:1em;
      margin-top: 0.5em;
      text-shadow:1px 1px black;
      background:rgba(0,0,0,0.65);
      border-radius:0.2em;
      padding:0.8em;
      display:inline-block;
    }
    .inner-right-slider hr{
      width:85%;
      float:left;
      clear:right;
      display:inline-block;
    }
    .inner-right-slider button{
      display: inline-block;
      clear:left;
      float:left;
      margin-top:1em;
      margin-left:2em;
      font-size:1.2em;
      padding:0.5em;
      padding-left:1em;
      padding-right:1em;
      font-weight: bold;
    }
    .kat-menu-btn{
      display: inline-block;
      width:100%;
      background:rgba(255,255,255,0.07);
      padding-top:0.5em;
      padding-bottom:0.5em;
      font-size: 1.1em;
      font-weight: bold;
      text-align: center;
      box-shadow:inset 0 0.2em 0.2em rgba(255,255,255,0.2),inset 0 -0.3em 0.2em rgba(0,148,255,0.1);
      cursor: pointer;
    }

    .kat-menu-hover{
      position: absolute;
      z-index: 1000;
      color:#000000;
      display: none;
      border:1px solid #333333;
      background: #FFFFFF;
      margin-left: 0em;
      margin-top: 0.5em;
      width: 100%;
    }
    .kat-listing{
      display: inline-block;
      float: left;
      width: 46%;
      height:14em;
      margin-left: 2.5%;
      background:url('img/kat.png');
      background-size: 50%;
      background-position: 4em center;
      background-repeat: no-repeat;
    }
    .kat-listing h4{
      display: inline-block;
      text-align: left;
      line-height: 0.7em;
      font-size: 1em;
      width: 90%;
      text-shadow: 1px 1px white;
    }
    .kat-listing a{
      display: inline-block;
      text-align: left;
      margin-bottom: 0.3em;
      font-size: 0.9em;
      text-shadow: 1px 1px white;
      width: 90%;
    }
    .search-tab{
      display: inline-block;
      width:100%;
      height: 2.4em;
    }
    .kat-menu{
      display: inline-block;
      width: 100%;
    }
    .search-tab label{
      display: none;
      float: left;
      margin-left: 1.5em;
      margin-top: 0.4em;
      font-size:1.2em;
    }
    .search-tab select{
      display: inline-block;
      float: left;
      margin-left: 1em;
      font-size:1em;
      margin-top: 0.7em;
      width: 25%;
    }
    .search-tab input{
      display: inline-block;
      float: left;
      margin-left: 1em;
      font-size:1em;
      margin-top: 0.7em;
      width: 40%;
      outline: none;
    }
    .search-tab button{
      display: inline-block;
      float: left;
      margin-left: 1em;
      font-size:1em;
      margin-top: 0.7em;
      width: 15%;
      outline: none;
    }
  }
</style>
