<!DOCTYPE html>
<html lang="cs">
  <link type="text/css" rel="stylesheet" id="dark-mode-general-link">
  <link type="text/css" rel="stylesheet" id="dark-mode-custom-link">
  <style lang="cz" type="text/css" id="dark-mode-custom-style"></style>
  <head>
    <meta charset="UTF-8">
    <title>Web IOT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

  $(document).ready(function() {
  printData("1hour");
});
        function printData(timeframe) {
            $.ajax({
                type: "POST",
      url: "get_graph.php",
                data: { timeframe: timeframe },
                success: function(data) {
                    $("#dataOutput").html(data);
                }
            });
        }

  $(document).ready(function() {
  printDataTable("1hour");
});
        function printDataTable(timeframe) {
            $.ajax({
                type: "POST",
      url: "get_table.php",
                data: { timeframe: timeframe },
                success: function(data) {
                    $("#dataOutput2").html(data);
                }
            });
        }
    </script>
  </head>
  <body>
    <div class="flex-container">
    <div class="flex-head">
      <h1>Web IOT</h1>
    </div>
    <div class="flex-section">
      <div>
        <h1 class="title">WiFi teploměr</h1>
        
        <div class="desc">
          <p>
            WiFi teploměr má 3 čidla, 2 teplotní a jedno měřící teplotu a vlhkosti, data přenáší na webový server pro další zpracování.
          </p>
          <p>
            Naměřená data pravidelně ukládaná do souboru <a href="https://iot.spst.cz/wifi.json" target="_blank">JSON</a>.
          </p>
        </div>
      </div>
      <div>

              <?php
                $url = "https://iot.spst.cz/wifi.json";
                $response = file_get_contents($url);
                
                $data = json_decode($response, true);
                
                ?>
              <div class="card-body">
                <h2 class="subtitle">Aktuálně naměřené hodnoty</h2>
                <div class="card-text json">
                  <?php foreach ($data as $key => $value) { ?>
                  <div class="item">
                    <div class="key"><?php echo $key ?></div>
                    : 
                    <div class="value"><?php echo $value ?>
                    <?php echo strpos($key, 'Vlhkost') !== false ? '%' : '°C' ?></div>
                  </div>
                  <?php } ?>
                </div>
              </div>
      </div>
      <div style="display: flex; justify-content: center; align-items: center;">
        <p>
          <button onclick="printData('1hour'); printDataTable('1hour')">Posledníí hodina</button>
          <button onclick="printData('4hours');printDataTable('4hours')">Poslední 4 hodiny</button>
          <button onclick="printData('12hours');printDataTable('12hours')">Posledních 12 hodin</button>
          <button onclick="printData('24hours');printDataTable('24hours')">Posledních 24 hodin</button>
        </p>
        </div>
        <div>
        <div id="dataOutput"></div>
      </div>
            <div style="display: flex; justify-content: center; align-items: center;">
        <div id="dataOutput2"></div>
      </div>
    </div>
    <div class="flex-foot">
      <p>©0ndra_m_  2020-<?php echo date("Y");?></p>
    </div>
  </body>
</html>