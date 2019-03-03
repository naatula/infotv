<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="manifest" href="infotv.webmanifest">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<link rel="stylesheet" type="text/css" href="infotv.css">

<?php
$credentials = parse_ini_file('credentials.ini');

$ip_whitelist = explode(" ", $credentials["ip_whitelist"]);
$ip = $_SERVER['REMOTE_ADDR'];
if(!empty($ip_whitelist[0]) && !in_array($ip, $ip_whitelist)){
  echo "</head><body>IP-osoite ei sallittu ($ip)</body></html>";
  exit();
}

$delay = $_GET["delay"];
if($delay){
  echo "<meta http-equiv='refresh' content='{$delay}; url=./' />";
}
?>
