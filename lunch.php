<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV Lounas</title>
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
      $monday = strtotime('monday this week',mktime(0, 0, 0, date("m"), date("d")+2));
      for ($i=0; $i<7; $i++){
        $lunch_time =  $monday + $i * 86400;
        $json_date = date('Y/m/d', $lunch_time);
        $file_path = "temp/lunch_{$lunch_time}.json";
        $json = file_get_contents($file_path);
        $menu = json_decode($json);
        if (!(file_exists($file_path) && (count($menu->courses) > 0 || time()-filemtime($file_path) < 86400))){
          ini_set('default_socket_timeout', 1);
          $json = file_get_contents("https://www.sodexo.fi/ruokalistat/output/daily_json/27843/{$json_date}/fi") or "";
          ini_set('default_socket_timeout', 60);
          $menu = json_decode($json);
          if (!empty($json)){
            if($file = fopen($file_path, w)){
              fwrite($file, $json);
              fclose($file);
            } else {
              trigger_error("Tiedostoa {$file_path} ei voitu luoda", E_USER_WARNING);
            }
          }

        }
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
    }
    }
     ?>
   </table>

    <a href="./">
      <i class="material-icons close">close</i>
    </a>
</body>
</html>
