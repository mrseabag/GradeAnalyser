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
  <title>Search</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  	<script src="javascriptsort.js"></script>
  
</head>
<body>
  <header>
    <h1>Search</h1>
  </header>

  <main>
    <div id="searchForm">
      <form method="POST">
        <label for="student">Search Student:</label>
        <input type="text" id="student" name="student" placeholder="Enter student name or ID">
        <button type="submit" name="searchBtn">Search</button>
      </form>
    </div>
	
	
    <?php
	
	
    // Check if the search form has been submitted
    if (isset($_POST['searchBtn'])) {
      // Connect to the MySQL database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "database123";
      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Get the search query from the form input
      $searchQuery = $_POST['student'];

      // Prepare the SQL statement to fetch the student data
      $stmt = $conn->prepare("SELECT * FROM test WHERE name LIKE ? OR id = ?");
      $stmt->bind_param("si", $searchQuery, $searchQuery);
      $stmt->execute();
      $result = $stmt->get_result();
			
			
	  
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $studentId = $row['id'];
          $studentName = $row['name'];
          $studentAge = $row['age'];
          $notes = $row['notes'];

          // Display the student information
          echo "<div class='studentInfo'>";
          echo "<h3>$studentName</h3>";
          echo "<p>Age: $studentAge</p>";

          // Display the notes section
          echo "<form method='POST'>";
          echo "<label for='notes'>Add or Add too Notes:</label>";
          echo "<textarea id='notes' name='notes'>$notes</textarea>";
          echo "<input type='hidden' name='studentId' value='$studentId'>";
          echo "<button type='submit' name='saveNotes'>Update Notes</button>";
          echo "</form>";

          echo "</div>";
        }
      } else {
        echo "<p>No student found.</p>";
      }

      // Close the database connection
      $conn->close();
    }

    // Check if the save notes button has been clicked
    if (isset($_POST['saveNotes'])) {
      // Get the student ID and notes from the form input
      $studentId = $_POST['studentId'];
      $notes = $_POST['notes'];

      // Connect to the MySQL database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "database123";
      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Prepare the SQL statement to update the student notes
      $stmt = $conn->prepare("UPDATE test SET notes = ? WHERE id = ?");
      $stmt->bind_param("si", $notes, $studentId);
      $stmt->execute();

      // Close the database connection
      $conn->close();

      echo "<p>Notes saved successfully.</p>";
    }
    ?>
  </main>
</body>
</html>
