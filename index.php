<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Newt-Sec</title>
</head>
<body>
  <div class="header">
    <h1>Newt-Sec</h1>
  </div>

<!DOCTYPE html>
<html>
<head>
    <title>Index Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	  <script src="javascriptencrypt.js"></script>
	  
	  <script>
			// Call a function from javascriptencrypt.js
			encryptData(sql);
			
			</script> 
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Welcome to the Import Tool</h1>
            <p>Please click the button below to proceed with importing data from an Excel file.</p>
            <div class="button-container">
                <button onclick="location.href='import.php'">Import Data</button>
				<button onclick="location.href='search.php'">Search user</button>
				<button onclick="location.href='graph.php'">graph</button>
				
            </div>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "database123";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM test";
            $result = $conn->query($sql);
			
            if ($result->num_rows > 0) {
                echo "<h2>Data in the Database:</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Country</th><th>English HL</th><th>Math AASL</th><th>Computer Science HL</th><th>French</th><th>Business</th><th>Health Science</th></tr>";
				
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["age"] . "</td>";
                    echo "<td>" . $row["country"] . "</td>";
                    echo "<td>" . $row["english_hl"] . "</td>";
                    echo "<td>" . $row["math_aasl"] . "</td>";
                    echo "<td>" . $row["computer_science_hl"] . "</td>";
                    echo "<td>" . $row["french"] . "</td>";
                    echo "<td>" . $row["business"] . "</td>";
                    echo "<td>" . $row["health_science"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
