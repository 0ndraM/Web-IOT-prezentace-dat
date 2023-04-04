<?php
// Connect to database
$host = "innodb.endora.cz";
$username = "0ndra";
$password = "Heslo1234";
$dbname = "0ndradb";
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Define SQL queries for the two timeframes
if ($_POST["timeframe"] == "4hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 4 HOUR AND MOD(id, 4) = 0;";
} else if ($_POST["timeframe"] == "1hour") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 1 HOUR";
} else if ($_POST["timeframe"] == "12hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 12 HOUR AND MOD(id, 12) = 0;";
} else if ($_POST["timeframe"] == "24hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 24 HOUR AND MOD(id, 24) = 0;";
}

// Define function to print data from query
function print_data($query) {
  global $conn;
  $result = mysqli_query($conn, $query);
//echo "Query: " . $query . "<br>";
//echo $_POST["timeframe"];
if ($result->num_rows > 0) {
     // Create the table
    echo '<table width=" "height="199"border="1" style="border-collapse: collapse;">';
    echo "<tr>";
    echo "<th>Čas</th>";
    echo "<th>Vlhkost</th>";
    echo "<th>Teplota 1</th>";
    echo "<th>Teplota 2</th>";
    echo "<th>Teplota 3</th>";
    echo "<th>ID</th>";
    echo "</tr>";
    // Loop through the results and create the rows
    while ($row = $result->fetch_assoc()) {
        $timestamp = date('H:i m/d', strtotime($row["timestamp"]));
        echo "<tr>";
        echo "<td>" . $timestamp."ㅤ". "</td>";
        echo "<td>" . $row['Vlhkost'] . '%'."</td>";
        echo "<td>" . $row['teplota1'] .'°C'. "</td>";
        echo "<td>" . $row['teplota2'] . '°C'."</td>";
        echo "<td>" . $row['teplota3'] . '°C'."</td>";
        echo "<td>" . $row['id'] . "</td>";
        echo "</tr>";
    }
    
    // Close the table
    echo "</table>";

  } else {
    echo "0 results";
  }
}

// Print data for the selected timeframe
print_data($query);

mysqli_close($conn);
?>
