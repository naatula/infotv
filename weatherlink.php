<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV</title>
  <?php
  $delay = $_GET["delay"];
  if($delay){
    echo "<meta http-equiv='refresh' content='{$delay}; url=./' />";
  }
  ?>

  <link rel="stylesheet" type="text/css" href="infotv.css">
</head>
<body id="weatherlink">
  <a href="./">
    <iframe src="https://www.weatherlink.com/embeddablePage/show/7b807ed7ef604ea982256f37bb69cf17/fullscreen"></iframe>
  </a>
</body>
</html>