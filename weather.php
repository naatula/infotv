<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV Sää</title>
  <?php include("head.php"); ?>

</head>

<?php
  $xml = simplexml_load_file("temp/weather.xml");

  $temp_out = $xml->temp_c;
  $temp_out_max = round(($xml->davis_current_observation->temp_day_high_f - 32) * (5/9),1);
#  $temp_out_max_time = $xml->davis_current_observation->temp_day_high_time;
  $temp_out_min = round(($xml->davis_current_observation->temp_day_low_f - 32) * (5/9),1);
#  $temp_out_min_time = $xml->davis_current_observation->temp_day_low_time;
  $temp_in = round(($xml->davis_current_observation->temp_in_f - 32) * (5/9),1);
  $temp_in_max = round(($xml->davis_current_observation->temp_in_day_high_f - 32) * (5/9),1);
#  $temp_in_max_time = $xml->davis_current_observation->temp_in_day_high_time;
  $temp_in_min = round(($xml->davis_current_observation->temp_in_day_low_f - 32) * (5/9),1);
#  $temp_in_min_time = $xml->davis_current_observation->temp_in_day_low_time;
  $feels_like = $xml->heat_index_c;
  $wind = round($xml->wind_mph*0.44704);
  $wind_dir = $xml->wind_degrees;
  $gust = round($xml->davis_current_observation->wind_day_high_mph*0.44704);
  $humidity_out = $xml->relative_humidity;
  $dewpoint = $xml->dewpoint_c;
  $rain = round($xml->davis_current_observation->rain_day_in * 25.4,1);
  $rain_rate = round($xml->davis_current_observation->rain_rate_in_per_hr * 25.4,2);
  $pressure = $xml->pressure_mb;
  $pressure_tendency = $xml->davis_current_observation->pressure_tendency_string;
  $pressure_trend = array(
    "Steady"=>"tasainen",
    "Rising Slowly"=>"nousee hitaasti",
    "Falling Slowly"=>"laskee hitaasti",
  )[strval($pressure_tendency)];

  $solar_radiation = round($xml->davis_current_observation->solar_radiation);
  $solar_radiation_max = round($xml->davis_current_observation->solar_radiation_month_high);
  $uv_index = $xml->davis_current_observation->uv_index;
  $sunset = date("H:i",strtotime($xml->davis_current_observation->sunset));
  $update_time = $xml->observation_time_rfc822;

 ?>

<body id="weather">
    <table class="title">
      <tr>
        <td class="name">Pohjois-Tapiolan lukion sääasema</td>
      </tr>
      <tr>
        <td id="outside" class="temperature">
          <i class="material-icons">&#xe564;</i>
          <div class="value"><?php echo $temp_out ?><span class="unit">°C</span></div>
          <div class="highlow">
            <table>
            <tr>
              <td>
                <i class="material-icons">&#xe80e;</i>
                <span class="value"><?php echo $temp_out_max ?><span class="unit">°C</span></span>
              </td>
              <td>
                <i class="material-icons">&#xe3ab;</i>
                <span class="value"><?php echo $sunset ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <i class="material-icons">&#xEB3B;</i>
                <span class="value"><?php echo $temp_out_min ?><span class="unit">°C</span></span>
              </td>
              <td>
                <i class="material-icons">&#xe7fd;</i>
                <span class="value"><?php echo $feels_like ?><span class="unit">°C</span></span>
              </td>
            </tr>
            </table>
          </div>
        </td>
        <td id="inside" class="temperature">
          <i class="material-icons">&#xe88a;</i>
          <div class="value"><?php echo $temp_in ?><span class="unit">°C</span></div>
          <div class="highlow">
            <table>
            <tr>
              <td>
                <i class="material-icons">&#xe80e;</i>
                <span class="value"><?php echo $temp_in_max ?><span class="unit">°C</span></span>
              </td>
            </tr>
            <tr>
              <td>
                <i class="material-icons">&#xEB3B;</i>
                <span class="value"><?php echo $temp_in_min ?><span class="unit">°C</span></span>
              </td>
            </tr>
            </table>
          </div>
        </td>
      </tr>
  </table>
  <table class="main">
      <tr>
        <td>
          Tuuli:
        </td>
        <td>
          <?php echo $wind ?><span class="unit">m/s</span><span class="extra"><?php echo $wind_dir ?>°</span>
        </td>
        <td>puuska tänään <?php echo $gust ?><span class="unit">m/s</span></td>
      </tr>

      <tr>
        <td>
          Ilmankosteus:
        </td>
        <td>
          <?php echo $humidity_out ?><span class="unit">%</span>
        </td>
        <td>kastepiste <?php echo $dewpoint ?><span class="unit">°C</span></td>
      </tr>

      <tr>
        <td>
          Sademäärä:
        </td>
        <td>
          <?php echo $rain ?><span class="unit">mm</span>
        </td>
        <td>
          <?php
          if (!$rain_rate){
            echo "ei sada";
          } else {
            echo "sataa " . $rain_rate . '<span class="unit">mm/h</span>';
          }
          ?>

        </td>
      </tr>

      <tr>
        <td>
          Ilmanpaine:
        </td>
        <td>
          <?php echo $pressure ?><span class="unit">hPa</span>
        </td>
        <td><?php echo $pressure_trend ?></td>
      </tr>

      <tr>
        <td>
          Auringon säteily:
        </td>
        <td>
          <?php echo $solar_radiation ?><span class="unit">W/m²</span>
        </td>
        <td>kuun suurin <?php echo $solar_radiation_max ?><span class="unit">W/m²</span></td>
      </tr>

      <tr>
        <td>
          UV-indeksi:
        </td>
        <td>
          <?php echo $uv_index ?>
        </td>
        <td>
          <?php
          if($uv_index == 0){
            echo "ei UV-säteilyä";
          } elseif ($uv_index < 2.5){
            echo "matala";
          } elseif ($uv_index < 5.5){
            echo "kohtalainen, suojaudu";
          } else {
            echo "korkea, suojaudu";
          }
           ?>
        </td>
      </tr>

      <tr>
        <td></td>
        <td></td>
        <td><?php echo $update_time ?></td>
      </tr>
    </table>

    <a href="./">
      <i class="material-icons close">close</i>
    </a>
</body>
</html>
