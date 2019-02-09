<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV Kello</title>
  <?php include("head.php"); ?>

  <?php
  $delay = $_GET["delay"];
  if($delay){
    echo "<meta http-equiv='refresh' content='{$delay}; url=./' />";
  }
  ?>

  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">

  <script>
    function toggleWlan() {
      var x = document.getElementById("wlan");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    }

    function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      h = checkTime(h);
      m = checkTime(m);
      document.getElementById('time').innerHTML =
      h + ":" + m;
      var t = setTimeout(startTime, 1000);
    }
    function checkTime(i) {
      if (i < 10) {i = "0" + i};
      return i;
    }
  </script>

</head>

<body id="clock" onload="startTime()">
    <table>
      <tr>
        <td>
          <div id="wlan" style="display: none;">
          <div id="ssid">espoo_training</div><div id="pass">OLab16#xT5n</div>
          </div>
          <div id="time"></div>
        </td>
      </tr>
    </table>
    </table>

    <a href="./">
      <div class="close material-icons button">close</div>
    </a>
    <a href="#">
      <div class="bottom_right material-icons button" onclick="toggleWlan()">wifi</div>
    </a>
</body>
</html>
