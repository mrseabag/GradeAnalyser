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
  <title>Subject Graph</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <header>
    <h1>Subject Graph</h1>
  </header>

  <main>
    <div id="studentSelect">
      <label for="search">Search Student:</label>
      <input type="text" id="search" placeholder="Enter Name or ID" oninput="searchStudent()">
    </div>
    <canvas id="subjectGraph"></canvas>
    <div id="studentInfo"></div>
    <button onclick="goBack()">Go Back</button>
  </main>

  <script>
    var students = <?php echo json_encode(getStudentsData()); ?>;

    var ctx = document.getElementById("subjectGraph").getContext("2d");
    var subjectChart;

    function createChart(studentsData) {
      if (subjectChart) {
        subjectChart.destroy();
      }

      subjectChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: students.subjects,
          datasets: studentsData.map(function(student) {
            return {
              label: student.name,
              data: student.grades,
              backgroundColor: getRandomColor()
            };
          })
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              max: 10
            }
          }
        }
      });
    }

    function searchStudent() {
      var searchValue = document.getElementById("search").value.toLowerCase();
      var studentInfo = document.getElementById("studentInfo");

      if (searchValue === "") {
        studentInfo.innerHTML = "";
        createChart(students.students);
      } else {
        var filteredStudents = students.students.filter(function(student) {
          return student.name.toLowerCase().includes(searchValue) || student.id === searchValue;
        });

        if (filteredStudents.length > 0) {
          var studentData = filteredStudents[0];
          var html = "<h3>" + studentData.name + "</h3><p>Age: " + studentData.age + "</p>";
          html += "<table><tr><th>Subject</th><th>Grade</th></tr>";

          for (var i = 0; i < students.subjects.length; i++) {
            var subject = students.subjects[i];
            var grade = studentData.grades[i];
            html += "<tr><td>" + subject + "</td><td>" + grade + "</td></tr>";
          }

          html += "</table>";
          studentInfo.innerHTML = html;

          // Create a new chart with only the selected student
          var selectedStudent = {
            name: studentData.name,
            grades: studentData.grades
          };

          createChart([selectedStudent]);
        } else {
          studentInfo.innerHTML = "No student found with the given name or ID.";
          createChart([]);
        }
      }
    }

    function getRandomColor() {
      var letters = '0123456789ABCDEF';
      var color = '#';

      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }

      return color;
    }

    function goBack() {
      window.history.back();
    }

    // Initial chart creation
    createChart(students.students);
  </script>
</body>
</html>

<?php
function getStudentsData() {
  // Connect to the MySQL database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "database123";
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch the student data from the database
  $studentQuery = "SELECT id, name, age, english_hl, math_aasl, computer_science_hl, french, business, health_science FROM test";
  $studentResult = $conn->query($studentQuery);

  $students = array();
  $subjects = array("english_hl", "math_aasl", "computer_science_hl", "french", "business", "health_science");

  if ($studentResult->num_rows > 0) {
    while ($studentRow = $studentResult->fetch_assoc()) {
      $student = array(
        "id" => $studentRow['id'],
        "name" => $studentRow['name'],
        "age" => $studentRow['age'],
        "grades" => array()
      );

      foreach ($subjects as $subject) {
        $student["grades"][] = $studentRow[$subject];
      }

      $students[] = $student;
    }
  }

  // Close the database connection
  $conn->close();

  return array(
    "students" => $students,
    "subjects" => $subjects
  );
}
?>
