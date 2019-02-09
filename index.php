<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV</title>
  <?php
  # Päivitä sivu tasa- ja puolitunnein
  if (date(i)<30){
    $refresh_time = mktime(date(H), 30, 10) - time();
  } else {
    $refresh_time = mktime(date(H), 60, 10) - time();
  }
  echo "<meta http-equiv='refresh' content='{$refresh_time}'>";
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <link rel="manifest" href="infotv.webmanifest">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="infotv.css">
  <script>
    /*monthNames = ["tammikuuta","helmikuuta","maaliskuuta","huhtikuuta","toukokuuta","kesäkuuta","heinäkuuta","elokuuta","syyskuuta","lokakuuta","marraskuuta","joulukuuta"]*/
    function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      /*var d = today.getDate();
      var mo = today.getMonth() ;*/
      h = checkTime(h);
      m = checkTime(m);
      document.getElementById('time').innerHTML =
      h + ":" + m;
      /*document.getElementById('date').innerHTML =
      d + ". " + monthNames[mo]*/

      /* Tarkistetaan, poistetaanko lounas näytöltä
      if(h>13){
        document.getElementById('lunch').innerHTML =
        "";
      }*/

      var t = setTimeout(startTime, 1000);
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
<body onload="startTime()">
  <div id="content">
    <iframe id="slides" src="https://docs.google.com/presentation/d/e/2PACX-1vRZpXNtuoV69BbfTlrbwIDCZeYL9OnmTwoej-gu7h0J68agp4C-OVSFMJsHjrFET4ui9A80EZutyhXr/embed?start=true&loop=true&delayms=20000&rm=minimal" frameborder="0"></iframe>
    <span id="topbar">
      <a href='weatherlink?delay=180'>
      <span id="weather">
        <?php
          if ((time()-filemtime("Weather.xml"))>1800) {
            ini_set('default_socket_timeout', 1);
            $data = file_get_contents("https://api.weatherlink.com/v1/NoaaExt.xml?user=[USER_ID]&pass=[PASSWORD]&apiToken=[API_TOKEN]") or "";
            ini_set('default_socket_timeout', 60);
            $data_valid = strlen($data)>100;
            if ($data_valid) {
              $xml = simplexml_load_string($data);
              $data_valid = strlen($xml->temp_c)>0 && strlen($xml->wind_degrees)>0 && strlen($xml->wind_mph)>0;
            }
            if (!$data_valid){
              $data_age = floor((time() - filemtime("Weather.xml")) / 3600);
              if ($data_age==0){
                echo("<span class='right_margin detail'>sää päivitetty alle tunti sitten</span>");
              } else {
                echo("<span class='right_margin detail'>sää päivitetty {$data_age}h sitten</span>");
              }

            }else{
              file_put_contents('Weather.xml', $data);
            }
          }

          $xml = simplexml_load_file("Weather.xml") or die("");
          $temp = str_replace(".",",",$xml->temp_c); # Yksi desimaali
          #$temp = round(floatval($xml->temp_c)); # Ei desimaaleja
          $wind_dir = intval($xml->wind_degrees);
          $wind = round($xml->wind_mph*0.44704);
          echo("<span class='right_margin'>{$temp}<span class='unit'>°C</span></span>");
          #echo("<span class='right_margin'>{$humidity}<span class='unit'>%</span></span>");
          echo("<span id='wind'><img class='compass' src='wind_arrow.svg' style='-webkit-transform: rotate({$wind_dir}deg); -ms-transform: rotate({$wind_dir}deg); transform: rotate({$wind_dir}deg);'>{$wind}<span class='unit'>m/s</span></span>");
        ?>
      </span>
      </a>
      <a href="clock?delay=21600">
      <span id="time">
      <?php
      date_default_timezone_set("Europe/Helsinki");
      echo date("H:i");
      ?>
      </span>
      </a>
      <a href="calendar?delay=180">
      <span id="date">
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
        <?php
        # Jos ruoka-aika on mennyt, huomisen ruoka
        $after_lunch = date(G)>13;
        if($after_lunch){
          $tomorrow  = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
          $json_date = date('Y/m/d', $tomorrow);
          $date_display = 'huomenna';
        } else {
          $json_date = date('Y/m/d');
          $date_display = 'tänään';
        }

        # Haetaan ruokalista sodexolta ja tulostetaan se
        ini_set('default_socket_timeout', 1);
        $json = file_get_contents("https://www.sodexo.fi/ruokalistat/output/daily_json/27843/{$json_date}/fi") or "";
        ini_set('default_socket_timeout', 60);
        $menu = json_decode($json);
        foreach($menu->courses as $item){
          $lunch[] = $item->title_fi;
        }

        if (!empty($lunch)){
          echo "<span id='lunch'>Lounas " . $date_display . ":<span class='left_margin lunch_option'>" . implode($lunch,"</span><span class='left_margin lunch_option'>") . "</span></span>";
        }
        ?>
    </span>
  </div>
</body>
