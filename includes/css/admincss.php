<style media="screen">
.b-container{
  display: inline-block;
  float: left;
  margin-top: 3em;
  width: 100%;
  text-align: center;
}

.b-innercontainer{
  display: inline-block;
  width: 90%;
  color: #222222;
  border: 4px solid #111111;
  margin-top:2em;
  margin-bottom:2em;
}
.l-tab{
  display: inline-block;
  width: 15%;
  color: #FFFFFF;
  background: #000000;
  float: left;
  border-right: 2px solid #111111;
}
.r-tab{
  display: inline-block;
  width: 84.5%;
  text-align: center;
  color: #FFFFFF;
  float: left;
}
.flexi-show{
  display: inline-block;
  background: #000000;
  margin-top: 2em;
  text-align: left;
  margin-bottom: 2em;
  border-radius:0.3em;
  width: 95%;
}
.flexi-show h3{
  display: inline-block;
  margin-left:1em;
  font-size: 2em;
}
.flexi-show p{
  display: inline-block;
  margin:1em;
  font-size: 1em;
  font-family: arial,sans-serif;
}
.branding-name{
  display: inline-block;
  margin-left: 1em;
  margin-top: 1em;
  font-weight: bold;
  border-bottom: 2px solid rgba(0,148,255,0.9);
  text-transform: uppercase;
  width:80%;
}
.editing-div-loader1{
  width:100%;
}
.editing-div-loader2{
  width:100%;
}
.editing-div-loader3{
  width:100%;
}
.editing-div-loader4{
  width:100%;
}
.editing-div-loader5{
  width:100%;
}
.editing-div-loader6{
  width:100%;
}
.editing-div-loader7{
  width:100%;
}
.btn-int-admin{
  display: inline-block;
  background:rgba(255,255,255,0.05);
  padding-top:0.5em;
  padding-bottom:0.5em;
  margin-left: 1em;
  padding-left: 1em;
  padding-right: 1em;
  font-size: 1em;
  border: 1px solid rgba(255,255,255,0.3);
  font-weight: normal;
  text-align: center;
  box-shadow:inset 0 0.2em 0.2em rgba(255,255,255,0.2),inset 0 -0.3em 0.2em rgba(0,148,255,0.1);
  cursor: pointer;
}
.fieldset{
  display: inline-block;
  width: 80%;
  margin-top: 0.8em;
  margin-bottom: 0.8em;
  margin-left: 1em;
}
.fieldset img{
  width:20%;
  margin-left: 1em;
}
#progressBar{
  width:80%;
  padding:1.5em;
  margin-left: 1em;
}
#filemsg{
  margin-left: 1em;
  font-weight: bold;
  font-size: 1.2em;
  color:rgba(0,148,255,0.9);
}
.fieldset label{
  display: inline-block;
  float: left;
  margin-bottom: 0.5em;
  width: 100%;
}
.fieldset label::before{
  content: "\2193";
  margin-right:1em;
  font-size: 1.2em;
}
.fieldset textarea{
  display: inline-block;
  float: left;
  background:rgba(255,255,255,0.05);
  outline: none;
  border-radius: 0.2em;
  border:1px solid rgba(0,148,255,0.25);
  color: #FFFFFF;
  font-family: arial, sans-serif;
  font-size: 1em;
  margin-left: 1em;
  box-shadow:inset 0 1em 1.5em rgba(255,255,255,0.1),inset 0 -1em 1.5em rgba(0,0,0,0.2);
  resize: none;
  padding: 0.5em;
  width: 80%;
  height: 8em;
}
.fieldset input{
  display: inline-block;
  float: left;
  padding: 0.5em;
  background:rgba(255,255,255,0.05);
  outline: none;
  border-radius: 0.2em;
  border:1px solid rgba(0,148,255,0.25);
  color: #FFFFFF;
  font-family: arial, sans-serif;
  font-size: 1em;
  margin-left: 1em;
  box-shadow:inset 0 1em 1.5em rgba(255,255,255,0.1),inset 0 -1em 1.5em rgba(0,0,0,0.2);
  resize: none;
  width: 80%;
}
.fieldset option{
  color:#000000;
}
.bordering{
  border:1px solid rgba(0,148,255,0.75);
  width:95%;
  margin-left: 2.5%;
  margin-top:1em;
  margin-bottom:1em;
}
.bordering h4{
  margin-left: 1em;
}
.choosegallery{
  display: inline-block;
  float: left;
  margin-left: 1em;
  margin-top: 1em;
  width:4em;
  cursor:pointer;
  border:0.4em solid #FFFFFF;
}
.existing-sub{
  border:1px solid rgba(255,255,255,0.75);
  width:45%;
  margin-left: 2.5%;
  margin-top:2em;
  margin-bottom:1em;
}
.existing-sub-rows:hover{
  background: rgba(255,255,255,0.05);
}
.existing-sub-rows{
  width:100%;
  padding-top: 0.3em;
  padding-bottom: 0.3em;
  border-top:1px solid rgba(255,255,255,0.45);
}
.existing-sub-rows a{
  margin-left: 1.5em;
}
.existing-sub-rows i{
  display: inline-block;
  float: right;
  cursor: pointer;
  margin-right: 1.5em;
}
.fieldset select{
  display: inline-block;
  float: left;
  padding: 0.5em;
  background:rgba(255,255,255,0.05);
  outline: none;
  border-radius: 0.2em;
  border:1px solid rgba(0,148,255,0.25);
  color: #FFFFFF;
  font-family: arial, sans-serif;
  font-size: 1em;
  margin-left: 1em;
  box-shadow:inset 0 1em 1.5em rgba(255,255,255,0.1),inset 0 -1em 1.5em rgba(0,0,0,0.2);
  resize: none;
  width: 80%;
}
.btn-rows-admin{
  display: inline-block;
  width:100%;
  background:rgba(255,255,255,0.03);
  padding-top:1em;
  padding-bottom:1em;
  font-size: 1.2em;
  font-weight: bold;
  text-align: center;
  box-shadow:inset 0 0.2em 0.2em rgba(255,255,255,0.2),inset 0 -0.3em 0.2em rgba(0,148,255,0.1);
  cursor: pointer;
}
.btn-rows-admin:hover{
  background:#000000;
  box-shadow:inset 0 0.4em 0.4em rgba(255,255,255,0.2);
}
.btn-rows-admin i{
  display: inline-block;
  float: left;
  margin-left: 2em;
}.btn-rows-admin a{
  display: inline-block;
  float: left;
  margin-left: 2em;
}
.existing-checkboxes{
  display: inline-block;
  width: 18%;
  float: left;
  margin-left: 1%;
  margin-top: 0.7em;

}
.checkboxInp{
  display: inline-block;
  background:none;
  outline: none;
  border-radius: 0.2em;
  border:1px solid rgba(0,148,255,0.25);
  color: #FFFFFF;
  font-family: arial, sans-serif;
  font-size: 1em;
  margin-right:0.5em;

}
.existing-check-rows{
  display: inline-block;
  width: 90%;
  margin-bottom: 2em;
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
    .l-tab{
      display: inline-block;
      width: 100%;
      color: #FFFFFF;
      background: #000000;
      float: left;
      border-right: none;
    }
    .btn-rows-admin{
      display: inline-block;
      width:50%;
      background:rgba(255,255,255,0.03);
      padding-top:1em;
      padding-bottom:1em;
      float: left;
      font-size: 0.9em;
      font-weight: bold;
      text-align: center;
      box-shadow:inset 0 0.2em 0.2em rgba(255,255,255,0.2),inset 0 -0.3em 0.2em rgba(0,148,255,0.1);
      cursor: pointer;
    }
    .btn-rows-admin:hover{
      background:#000000;
      box-shadow:inset 0 0.4em 0.4em rgba(255,255,255,0.2);
    }
    .btn-rows-admin i{
      display: inline-block;
      float: left;
      margin-left: 1em;
    }.btn-rows-admin a{
      display: inline-block;
      float: left;
      margin-left: 1em;
    }
    .r-tab{
      display: inline-block;
      width: 100%;
      text-align: center;
      color: #FFFFFF;
      float: left;
    }
    .flexi-show{
      display: inline-block;
      background: #000000;
      margin-top: 2em;
      margin-bottom: 2em;
      border-radius:0.3em;
      width: 95%;
    }
    .fieldset img{
      width:40%;
      margin-left: 1em;
    }
    #progressBar{
      width:80%;
      padding:1em;
      margin-left: 1em;
    }
    #filemsg{
      margin-left: 1em;
      font-weight: bold;
      font-size: 1em;
      color:rgba(0,148,255,0.9);
    }
    .existing-sub{
      border:1px solid rgba(255,255,255,0.75);
      width:85%;
      margin-left: 2.5%;
      margin-top:2em;
      margin-bottom:1em;
    }
  }
</style>
