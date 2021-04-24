<style media="screen">
  .b-container{
    display: inline-block;
    float: left;
    margin-top: 5.8em;
    width: 100%;
    text-align: center;
  }

  .b-innercontainer{
    display: inline-block;
    width: 80%;
    color: #222222;
    border: 4px solid #111111;
    margin-top:2em;
    margin-bottom:2em;
  }
  .action-div{
    display: inline-block;
    float: left;
    width: 50%;
    text-align: center;
  }
  .description-div{
    display: inline-block;
    float: left;
    width: 50%;
    text-align: center;
  }
  .action-inner{
    display: inline-block;
    width: 95%;
    border-right:2px solid #111111;
    text-align: left;
    margin-top:1em;
    margin-bottom:1em;
  }
  .description-inner{
    display: inline-block;
    width: 95%;
    text-align: left;
  }
  .description-inner h3{
    margin-left:4em;
    text-decoration: underline;
    margin-top: 2em;
    font-size: 1.8em;
  }
  .description-inner p{
    display: inline-block;
    margin-left:15%;
    margin-right: 20%;
    font-size: 1.5em;
    font-family:arial, sans-serif;
    font-weight:bold;
  }
  .description-inner button{
    display:inline-block;
    width: 30%;
    font-size:1.2em;
    font-family:arial, sans-serif;
    font-weight:bold;
    padding-top:0.5em;
    padding-bottom:0.5em;
    cursor: pointer;
    margin-left:20%;
    margin-bottom:2em;
    margin-top:1em;
  }
  .action-inner h3{
    margin-left:4em;
    text-decoration: underline;
    font-size: 1.8em;
  }
  .action-inner p{
    display:inline-block;
    width:100%;
  }
  .be-logged{
    display:inline-block;
    width:50%;
    margin-left:20%;
  }
  .be-logged a{
    display: inline-block;
    float: left;
  }
  .def-be-logged{
    font-size: 0.7em;
  }
  .forget-pass{
    font-weight: bold;
    color: blue;
    text-decoration: underline;
    cursor: pointer;
  }
  .action-inner label{
    display:inline-block;
    width: 70%;
    margin-left:20%;
  }
  .action-inner input{
    display:inline-block;
    width: 50%;
    outline: none;
    border:1px solid #AAAAAA;
    box-shadow:inset 0 0.2em 0.2em rgba(0,0,0,0.25);
    color: #222222;
    padding-left:0.8em;
    padding-top:0.5em;
    padding-bottom:0.5em;
    margin-left:20%;
    font-size:1.2em;
  }
  .action-inner button{
    display:inline-block;
    width: 30%;
    font-size:1.2em;
    font-family:arial, sans-serif;
    font-weight:bold;
    padding-top:0.5em;
    padding-bottom:0.5em;
    cursor: pointer;
    margin-left:20%;
    margin-bottom:2em;
    margin-top:1em;
  }
  .errorhandler{
    display: inline-block;
    width: 100%;
    text-align: center;
  }
  .inner-error{
    display: <?php print($errframe); ?>;
    width: 70%;
    background:rgba(255,0,0,0.80);
    color:#FFFFFF;
    text-shadow:1px 1px black;
    font-weight: bold;
    border:1px solid #FF0000;
    padding:0.3em;
    padding-left:1em;
    padding-right:1em;
    text-align: left;
  }
  .inner-error li{
    line-height: 1.5em;
  }
  @media screen and (max-width: 500px) {
    .b-container{
      display: inline-block;
      float: left;
      margin-top: 2em;
      width: 100%;
      text-align: center;
    }

    .b-innercontainer{
      display: inline-block;
      width: 90%;
      color: #222222;
      border: 4px solid #111111;
      margin-top:1em;
      margin-bottom:2em;
    }
    .action-div{
      display: inline-block;
      float: left;
      width: 100%;
      text-align: center;
    }
    .description-div{
      display: inline-block;
      float: left;
      width: 100%;
      text-align: center;
    }
    .action-inner{
      display: inline-block;
      width: 95%;
      border-right:none;
      border-bottom:2px solid #111111;
      text-align: left;
      margin-top:1em;
      margin-bottom:1em;
    }
    .description-inner{
      display: inline-block;
      width: 95%;
      text-align: left;
    }
    .description-inner h3{
      margin-left:2em;
      text-decoration: underline;
      margin-top: 2em;
      font-size: 1.5em;
    }
    .description-inner p{
      display: inline-block;
      margin-left:15%;
      margin-right: 15%;
      font-size: 1.2em;
      font-family:arial, sans-serif;
      font-weight:bold;
    }
    .description-inner button{
      display:inline-block;
      width: 50%;
      font-size:1em;
      font-family:arial, sans-serif;
      font-weight:bold;
      padding-top:0.5em;
      padding-bottom:0.5em;
      cursor: pointer;
      margin-left:20%;
      margin-bottom:2em;
      margin-top:1em;
    }
    .action-inner h3{
      margin-left:4em;
      text-decoration: underline;
      font-size: 1.5em;
    }
    .action-inner p{
      display:inline-block;
      width:100%;
    }
    .be-logged{
      width: 70%;
      margin-left:15%;
    }
    .action-inner label{
      display:inline-block;
      width: 70%;
      margin-left:20%;
    }
    .action-inner input{
      display:inline-block;
      width: 50%;
      outline: none;
      border:1px solid #AAAAAA;
      box-shadow:inset 0 0.2em 0.2em rgba(0,0,0,0.25);
      color: #222222;
      padding-left:0.8em;
      padding-top:0.5em;
      padding-bottom:0.5em;
      margin-left:20%;
      font-size:1.2em;
    }
    .action-inner button{
      display:inline-block;
      width: 50%;
      font-size:1em;
      font-family:arial, sans-serif;
      font-weight:bold;
      padding-top:0.5em;
      padding-bottom:0.5em;
      cursor: pointer;
      margin-left:20%;
      margin-bottom:2em;
      margin-top:1em;
    }
  }
</style>
