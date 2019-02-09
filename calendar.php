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
<body id="calendar">
  <a href="./">
    <iframe src="https://www.google.com/calendar/embed?src=8khe2ngv0i2rvgpn58s20i331s%40group.calendar.google.com&ctz=Europe/Helsinki"></iframe>
    <div id="calendar_bar">Paina mistä tahansa palataksesi</div>
  </a>
</body>
</html>
