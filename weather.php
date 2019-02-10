<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>InfoTV Sää</title>
  <?php include("head.php"); ?>

</head>

<body id="weather">
    <table class="title">
      <tr>
        <td class="name">Pohjois-Tapiolan lukion sääasema</td>
      </tr>
      <tr>
        <td id="outside" class="temperature">
          <span class="material-icons">landscape</span>
          <div class="value">0,0<span class="unit">°C</span></div>
          <div class="highlow">
            <table>
            <tr>
              <td>
                <span class="material-icons">whatshot</span>
                <span class="value">2,5°</span>
              </td>
              <td>04:34</td></tr>
            <tr>
              <td>
                <span class="material-icons">ac_unit</span>
                <span class="value">-1,3°</span>
              </td>
              <td>15:44</td></tr>
            </table>
          </div>
        </td>
        <td id="inside" class="temperature">
          <span class="material-icons">home</span>
          <div class="value">21,5<span class="unit">°C</span></div>
          <div class="highlow">
            <table>
            <tr>
              <td>
                <span class="material-icons">whatshot</span>
                <span class="value">22,5°</span>
              </td>
              <td>16:35</td></tr>
            <tr>
              <td>
                <span class="material-icons">ac_unit</span>
                <span class="value">19,3°</span>
              </td>
              <td>02:44</td></tr>
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
          10<span class="unit">m/s</span><span class="extra">240°</span>
        </td>
        <td>puuska tänään 16<span class="unit">m/s</span></td>
      </tr>

      <tr>
        <td>
          Ilmankosteus:
        </td>
        <td>
          100<span class="unit">%</span>
        </td>
        <td>kastepiste 2,0<span class="unit">°C</span></td>
      </tr>

      <tr>
        <td>
          Sademäärä:
        </td>
        <td>
          10<span class="unit">mm</span>
        </td>
        <td>tällä hetkellä ei sada</td>
      </tr>

      <tr>
        <td>
          Ilmanpaine:
        </td>
        <td>
          1000.0<span class="unit">hPa</span>
        </td>
        <td>kasvaa</td>
      </tr>

      <tr>
        <td>
          Auringon säteily:
        </td>
        <td>
          10<span class="unit">W/m²</span>
        </td>
        <td>suurin tänään 100<span class="unit">W/m²</span></td>
      </tr>

      <tr>
        <td>
          UV-indeksi:
        </td>
        <td>
          0
        </td>
        <td>ei UV-säteilyä</td>
      </tr>

      <tr>
        <td></td>
        <td></td>
        <td>Päivitetty 21.4.2019 16:21</td>
      </tr>
    </table>

    <a href="./">
      <div class="close material-icons button">close</div>
    </a>
</body>
</html>
