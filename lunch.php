<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV Sää</title>
  <?php include("head.php"); ?>

</head>

<body id="lunch">
    <table id="title">
      <tr>
        <td>Lounaslista</td>
      </tr>
    </table>
    <table id="main">
      <?php
      date_default_timezone_set("Europe/Helsinki");
      $days_of_the_week = array("su","ma","ti","ke","to","pe","la");
      $row_count = 0;
      $consecutive_fails = 0;
      for ($i=-1; ($consecutive_fails<3 && $row_count< 8); $i++){
        $lunch_time = mktime(0, 0, 0, date("m"), date("d") + $i, date("Y"));
        $json_date = date('Y/m/d', $lunch_time);

        if (file_exists("temp/lunch_{$lunch_time}.json")){
          $json = file_get_contents("temp/lunch_{$lunch_time}.json");
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

        }
      $menu = json_decode($json);
      $lunch = array();
      foreach($menu->courses as $item){
        $entry = $item->title_fi;
        if(!empty($item->category)){
          $entry = $entry . " <span class='properties'>" . $item->category;

          if(!empty($item->properties)){
            $entry = $entry . ", " . $item->properties;
          }
          $entry = $entry . "</span>";
        }

        $lunch[] = $entry;

      }
      if (!empty($lunch)){
      echo "<tr";
        if ($lunch_time == mktime(0, 0, 0, date("m"), date("d"), date("Y"))){
          echo " class='today'";
        }
      echo "><td>" . $days_of_the_week[date('w', $lunch_time)] . date(' d.m.', $lunch_time) . "</td>";
      echo "<td>" . implode($lunch, "<br>") . "</td>";
      echo "</tr>";
      $row_count++;
      $consecutive_fails = 0;
    } else {
      $consecutive_fails++;
    }
    }
     ?>
   </table>

    <a href="./">
      <i class="material-icons close">close</i>
    </a>
</body>
</html>
