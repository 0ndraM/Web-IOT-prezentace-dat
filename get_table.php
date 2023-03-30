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
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 12 HOUR";
} else if ($_POST["timeframe"] == "24hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 24 HOUR";
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
        echo "<td>" . $timestamp. "</td>";
        echo "<td>" . $row['Vlhkost'] . "</td>";
        echo "<td>" . $row['teplota1'] . "</td>";
        echo "<td>" . $row['teplota2'] . "</td>";
        echo "<td>" . $row['teplota3'] . "</td>";
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

// Define SQL queries for the two timeframes
if ($_POST["timeframe"] == "4hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 4 HOUR";
} else if ($_POST["timeframe"] == "1hour") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 1 HOUR";
} else if ($_POST["timeframe"] == "12hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 12 HOUR";
} else if ($_POST["timeframe"] == "24hours") {
  $query = "SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 24 HOUR";
}

// Define function to count rows matching query
function count_rows($query) {
  global $conn;
  $result = mysqli_query($conn, $query);

  if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
  }

  return $result->num_rows;
}

/* Print count of rows matching each query
echo "1 hour interval: " . count_rows("SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 1 HOUR") . "<br>";
echo "4 hour interval: " . count_rows("SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 4 HOUR") . "<br>";
echo "12 hour interval: " . count_rows("SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 12 HOUR") . "<br>";
echo "24 hour interval: " . count_rows("SELECT * FROM wifi_data WHERE timestamp >= NOW() - INTERVAL 24 HOUR") . "<br>";

Close database connection
*/
mysqli_close($conn);
?>