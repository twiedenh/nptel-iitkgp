<?php

$dir = scandir("json_db", SCANDIR_SORT_ASCENDING);
$dscArray = array();
foreach($dir as $filename){
	if(preg_match("/dbDisciplineList[0-9]*\.json/", $filename, $mDl)){
		$dscArray = array_merge($dscArray, json_decode(file_get_contents ("json_db/".$mDl[0]), true));
	}
}
$action = "";
if(!isset($_GET["dscId"])){
  $action = "showmainpage";
}elseif(isset($_GET["dscId"])){
  $foundFlg = 0;
  foreach ( $dscArray as $dsc ){
    if ($_GET["dscId"] === $dsc["id"]){$foundFlg = 1;break;}
  }
  if($foundFlg == 1){
    $subjArray = array();
    $lecArray = array();
    foreach($dir as $filename){
      if(preg_match("/dbSubjectList[0-9]*\.json/", $filename, $mSl)){
        $subjArray = array_merge($subjArray, json_decode(file_get_contents ("json_db/".$mSl[0]), true));
//      }elseif(preg_match("/dbLectureList[0-9]*\.json/", $filename, $mLl)){
//        $lecArray = array_merge($lecArray, json_decode(file_get_contents ("json_db/".$mLl[0]), true));
        }
    }
    $action = "showsubjectpage";
  }
}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php 
        if($action === "showmainpage"){echo "NPTEL: Discipline List";}
        elseif ($action == "showsubjectpage"){echo "NPTEL: Subject List";}
      ?></title>
  <style>
  .container{
    min-width: 480px;
    position:absolute;
    left:0px;
    top:0px;
    right:0px;
  }
  a{
    text-decoration: none;
    font-family: "Verdana", "Arial";
    font-weight: bold;
  }
  #header{
    height:50px;
    background-color:#FFF;
    border-bottom: 1px #000 solid;
    padding:5px 0px 5px 5px;
  }
  #header img{
    height: 45px;
    background-color:#FFF;
    border-right: 1px #000 solid;
    display: inline-block;
  }
  #header .heading{
    display: inline-block;
    font-size: 12pt;
    vertical-align: top;
  }
  #header .heading h4,h6{
    margin: 0px !important;
    line-height: 20pt;
  }
  #header .heading h6{
    border-top: 1px #000 solid;
  }
  .main-panel{
    margin-top: 65px;
    min-width: 480px;
  }
  .main-panel .discp{
    border: 1px #000 solid;
    display: inline-grid;
    min-width: 145px;
    min-height: 200px;
    max-width: 300px;
    max-height: 400px;
    width: calc(100vw/5) - 10;
    margin: 4px;
    font-family: "verdana";
    font-size: 9pt;
    text-align: center;
    overflow:hidden;
    height: auto;
    border-radius: 3px;
  }
  .main-panel .discp img{
    padding: 5px;
    min-width: 130px;
    min-height: 130px;
    max-width: 380px;
    max-height: 380px;
    width: calc(100vw/6);
    height: calc(100vh/5);
    clip: rect(0px,60px,200px,0px);
    overflow:hidden;
  }
  .main-panel .discp .text{
    padding: 5px;
    padding-top: 0px;
    min-width: 130px;
    max-width: 380px;
    width: calc(100vw/6);
    height: 30px;
  }
  </style>
 </head>
 <body>
  <div class="container">
   <div id="header">
    <img src="/nptel/img/banner500x100.png">
    <div class="heading">
      <h4>NPTEL - Web and Video Courses</h4>
      <h6><?php 
        if($action === "showmainpage"){echo "<a href=\"".$_SERVER['REQUEST_URI']."\">Home</a>";}
        elseif ($action == "showsubjectpage"){echo "<a href=\"/nptel/\">Home</a> &gt;&gt;
          <a href=\"".$_SERVER['REQUEST_URI']."\">".$dsc["Name"]."</a>";}
      ?></h6>
    </div>
    </div>
   </div>
  </div>
  <ul class="main-panel">
    <?php
        if($action == "showmainpage"){
          foreach ( $dscArray as $dsc ){
            echo ("<li class='discp'><a href='".$dsc["id"]."'>
              <img src=\"/nptel/img/".$dsc["id"].".jpg\" onerror=\"this.src='/nptel/img/BSc.jpg';\"/><div class='text'>".$dsc["Name"]."</div></a></li>");
          }
        } elseif ($action == "showsubjectpage"){
          foreach ( $subjArray as $subj ){
            //var_dump($subjArray); exit;
            if ($subj[1] === $dsc["id"]){
              echo ("<a href='DisplayVideo/".$subj[0]."'>".$subj[4]."</a><br>");
            }
          }
        }
    ?>
  </ul>
 </body>
</html>