<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV Kello</title>
  <?php include("head.php"); ?>

  <script>
    function toggleWlan() {
      var info = document.getElementById("wlan");
      var icon = document.getElementById("wlan_toggle");
      if (info.style.display === "none") {
        info.style.display = "block";
        icon.style.color = "#ccc";
      } else {
        info.style.display = "none";
        icon.style.color = "";
      }
    }

    function toggleSeconds() {
      var x = document.getElementById("seconds");
      var icon = document.getElementById("seconds_toggle");
      if (x.style.display === "none") {
        x.style.display = "inline";
        icon.style.color = "#ccc";
      } else {
        x.style.display = "none";
        icon.style.color = "";
      }
    }

    function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      h = checkTime(h);
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('time').innerHTML =
      h + ":" + m;
      document.getElementById('seconds').innerHTML =
      ":" + s;
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
          <div id="time"></div><div id="seconds" style="display: none;"></div>
        </td>
      </tr>
    </table>

    <a href="./">
      <div class="material-icons clock_button close">&#xe5cd;</div>
    </a>
      <div class="bottom_right">
        <a href="#">
          <div id="wlan_toggle" class="material-icons clock_button" onclick="toggleWlan()">&#xe63e;</div></a>
        <a href="#">
          <div id="seconds_toggle" class="material-icons clock_button" onclick="toggleSeconds()">&#xe425;</div>
        </a>
      </div>
</body>
</html>
