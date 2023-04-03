<?php
// Connect to database
$host = "innodb.endora.cz";
$username = "";
$password = "";
$dbname = "0ndradb";
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}


// Define SQL queries for the two timeframes
if ($_POST["timeframe"] == "4hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 4 HOUR";
} else if ($_POST["timeframe"] == "1hour") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 1 HOUR";
} else if ($_POST["timeframe"] == "12hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 12 HOUR AND MOD(id, 3) = 0;";
} else if ($_POST["timeframe"] == "24hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 24 HOUR AND MOD(id, 6) = 0;";
}


// Define function to print data from query
function print_data($query) {
  global $conn;
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
// Format the data for Chart.js
$labels = array();
$vlhkost_data = array();
$teplota1_data = array();
$teplota2_data = array();
$teplota3_data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $timestamp = date('H:i', strtotime($row["timestamp"]));
        $labels[] = $timestamp;
        $vlhkost_data[] = $row["Vlhkost"];
        $teplota1_data[] = $row["teplota1"];
        $teplota2_data[] = $row["teplota2"];
        $teplota3_data[] = $row["teplota3"];
    }
}

// Create a canvas element
echo '<canvas id="myChart"></canvas>';

// Initialize Chart.js
echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
echo '<script>';
echo 'var ctx = document.getElementById("myChart").getContext("2d");';
echo 'var myChart = new Chart(ctx, {';
echo 'type: "line",';
echo 'data: {';
echo 'labels: ' . json_encode($labels) . ',';
echo 'datasets: [{';
echo 'label: "Vlhkost",';
echo 'data: ' . json_encode($vlhkost_data) . ',';
echo 'backgroundColor: "rgba(255, 99, 132, 0.2)",';
echo 'borderColor: "rgba(255, 99, 132, 1)",';
echo 'borderWidth: 1';
echo '},{';
echo 'label: "Teplota 1",';
echo 'data: ' . json_encode($teplota1_data) . ',';
echo 'backgroundColor: "rgba(54, 162, 235, 0.2)",';
echo 'borderColor: "rgba(54, 162, 235, 1)",';
echo 'borderWidth: 1';
echo '},{';
echo 'label: "Teplota 2",';
echo 'data: ' . json_encode($teplota2_data) . ',';
echo 'backgroundColor: "rgba(255, 206, 86, 0.2)",';
echo 'borderColor: "rgba(255, 206, 86, 1)",';
echo 'borderWidth: 1';
echo '},{';
echo 'label: "Teplota 3",';
echo 'data: ' . json_encode($teplota3_data) . ',';
echo 'backgroundColor: "rgba(75, 192, 192, 0.2)",';
echo 'borderColor: "rgba(75, 192, 192, 1)",';
echo 'borderWidth: 1';
echo '}]';
echo '},';
echo 'options: {';
echo 'scales: {';
echo 'yAxes: [{';
echo 'ticks: {';
echo 'beginAtZero: true';
echo '}';
echo '}]';
echo '}';
echo '}';
echo '});';
echo '</script>';
$conn->close();


  }
  
}

// Print data for the selected timeframe
print_data($query);

// Close database connection
mysqli_close($conn);
?>
