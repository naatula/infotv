<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV Kalenteri</title>
  <?php include("head.php"); ?>
  <?php
  $delay = $_GET["delay"];
  if($delay){
    echo "<meta http-equiv='refresh' content='{$delay}; url=./' />";
  }
  ?>

</head>
<body id="calendar">
    <iframe src="https://www.google.com/calendar/embed?src=8khe2ngv0i2rvgpn58s20i331s%40group.calendar.google.com&ctz=Europe/Helsinki&hl=fi"></iframe>
    <div id="calendar_bar"></div>
    <div id="calendar_noclick"></div>
    <a href="./">
      <div class="close material-icons">close</div>
    </a>
</body>
</html>
