<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV</title>
  <?php include("head.php"); ?>
  <?php
  # Päivitä sivu tasa- ja puolitunnein
  if (date(i)<30){
    $refresh_time = mktime(date(H), 30, 10) - time();
  } else {
    $refresh_time = mktime(date(H), 60, 10) - time();
  }
  echo "<meta http-equiv='refresh' content='{$refresh_time}'>";
  ?>
  <script>
var startDate = new Date();
var lastMinutes = startDate.getMinutes();
var lastDay = startDate.getDate();
document.addEventListener("DOMContentLoaded", function() {
  setInterval(startTime, 1000);
})
monthNames = ["tammikuuta","helmikuuta","maaliskuuta","huhtikuuta","toukokuuta","kesäkuuta","heinäkuuta","elokuuta","syyskuuta","lokakuuta","marraskuuta","joulukuuta"]
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var d = today.getDate();
  var mo = today.getMonth() ;
  h = checkTime(h);
  m = checkTime(m);
  if (lastMinutes !== m) {
    document.getElementById('time').innerHTML =
    h + ":" + m;
    lastMinutes = m;
  }
  if(lastDay !== d){
    document.getElementById('date').innerHTML =
    d + ". " + monthNames[mo];
    lastDay = d;
  }
}

function checkTime(i) {
  if (i < 10) {i = "0" + i};
  return i;
}
</script>
<noscript>
  <style media="screen">
    #time {
      visibility: hidden;
    }
  </style>
</noscript>
</head>
<body>
  <div id="content">
    <iframe id="slides" src="https://docs.google.com/presentation/d/e/2PACX-1vRZpXNtuoV69BbfTlrbwIDCZeYL9OnmTwoej-gu7h0J68agp4C-OVSFMJsHjrFET4ui9A80EZutyhXr/embed?start=true&loop=true&delayms=20000&rm=minimal" frameborder="0"></iframe>
    <span id="topbar">
      <a href='weather?delay=180'>
      <span id="weather" class="link">
        <?php
          if ((time()-filemtime("temp/weather.xml"))>900) {
            $credentials = parse_ini_file('credentials.ini');
            $user = $credentials["wl_user"];
            $pass = $credentials["wl_pass"];
            $apiToken = $credentials["wl_apiToken"];
            ini_set('default_socket_timeout', 1);
            $data = file_get_contents("https://api.weatherlink.com/v1/NoaaExt.xml?user={$user}&pass={$pass}&apiToken={$apiToken}") or "";
            ini_set('default_socket_timeout', 60);
            $data_valid = strlen($data)>100;
            if ($data_valid) {
              $xml = simplexml_load_string($data);
              $data_valid = strlen($xml->temp_c)>0 && strlen($xml->wind_degrees)>0 && strlen($xml->wind_mph)>0;
            }
            if ($data_valid){
              file_put_contents('temp/weather.xml', $data) or trigger_error("Tiedostoon temp/weather.xml ei voitu kirjoittaa", E_USER_WARNING);
            }
          }

          if($xml = simplexml_load_file("temp/weather.xml")){

            $data_age = floor((time() - strtotime($xml->observation_time_rfc822)) / 3600);
            if ($data_age>0){
              echo("<span class='right_padding detail'>sää päivitetty {$data_age}h sitten</span>");
            }

            $temp = str_replace(".",",",$xml->temp_c); # Yksi desimaali
            #$temp = round(floatval($xml->temp_c)); # Ei desimaaleja
            $wind_dir = intval($xml->wind_degrees);
            $wind = round($xml->wind_mph*0.44704);
            echo("<span class='right_padding'>{$temp}<span class='unit'>°C</span></span>");
            #echo("<span class='right_margin'>{$humidity}<span class='unit'>%</span></span>");
            echo("<span id='wind'><img class='wind_arrow' src='wind_arrow.svg' style='-webkit-transform: rotate({$wind_dir}deg); -ms-transform: rotate({$wind_dir}deg); transform: rotate({$wind_dir}deg);'>{$wind}<span class='unit'>m/s</span></span>");
          } else {
            echo "Ei säätietoja";
          }
        ?>
      </span>
      </a>
      <a href="clock?delay=21600">
      <span id="time" class="link">
      <?php
      date_default_timezone_set("Europe/Helsinki");
      echo date("H:i");
      ?>
      </span>
      </a>
      <a href="calendar?delay=180">
      <span id="date" class="link">
        <?php
        $month_names = array("tammikuuta", "helmikuuta", "maaliskuuta", "huhtikuuta", "toukokuuta", "kesäkuuta", "heinäkuuta", "elokuuta", "syyskuuta", "lokakuuta", "marraskuuta", "joulukuuta");
        $day = date('j');
        $month = $month_names[intval(date('m')) - 1];
        echo $day . ". " . $month
        ?>
      </span>
      </a>
    </span>
    <span id='bottombar'>
      <span id='lunch'>
        <?php
        $after_lunch = date(G)>12;
        if($after_lunch){
          $lunch_in_days = 0;
        } else {
          $lunch_in_days = -1;
        }

        do {
          $lunch_in_days = $lunch_in_days + 1;
          $lunch_time = mktime(0, 0, 0, date("m"), date("d") + $lunch_in_days, date("Y"));
          $json_date = date('Y/m/d', $lunch_time);


          if (file_exists("temp/lunch_{$lunch_time}.json")){
            $json = file_get_contents("temp/lunch_{$lunch_time}.json");
            $menu = json_decode($json);
            foreach($menu->courses as $item){
              $lunch[] = $item->title_fi;
            }
          } else {
            ini_set('default_socket_timeout', 1);
            $json = file_get_contents("https://www.sodexo.fi/ruokalistat/output/daily_json/27843/{$json_date}/fi") or "";
            ini_set('default_socket_timeout', 60);
            if (!empty($json)){
              if($file = fopen("temp/lunch_{$lunch_time}.json", w)){
                fwrite($file, $json);
                fclose($file);
              } else {
                trigger_error("Tiedostoa temp/lunch_{$lunch_time}.json ei voitu luoda", E_USER_WARNING);
              }
            }

            $menu = json_decode($json);
            foreach($menu->courses as $item){
              $lunch[] = $item->title_fi;
            }

          }


        } while (($lunch_in_days < 3) && (empty($lunch)));

        if ($lunch_in_days == 0){
          $date_display = "tänään";
        } elseif ($lunch_in_days == 1){
          $date_display = "huomenna";
        } else {
          $date_display = array("sunnuntaina","maanantaina","tiistaina","keskiviikkona","torstaina","perjantaina","lauantaina")[date(w,$lunch_time)];
        }

        if (!empty($lunch)){
          echo "Lounas " . $date_display . ":<span class='left_margin lunch_option'>" . implode($lunch,"</span><span class='left_margin lunch_option'>") . "</span>";
        } else {
          echo "Hyvää lomaa!";
        }
        ?>
      </span>
    </span>
  </div>
</body>
</html>
