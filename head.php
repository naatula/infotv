<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="manifest" href="infotv.webmanifest">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<link rel="stylesheet" type="text/css" href="infotv.css">

<?php
$delay = $_GET["delay"];
if($delay){
  echo "<meta http-equiv='refresh' content='{$delay}; url=./' />";
}
?>
