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
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Country</th><th>English HL</th><th>Math AASL</th><th>Computer Science HL</th><th>French</th><th>Business</th><th>Health Science</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["age"] . "</td><td>" . $row["country"] . "</td><td>" . $row["english_hl"] . "</td><td>" . $row["math_aasl"] . "</td><td>" . $row["computer_science_hl"] . "</td><td>" . $row["french"] . "</td><td>" . $row["business"] . "</td><td>" . $row["health_science"] . "</td></tr>";
    }

    echo "</table>";
}

$conn->close();
?>
