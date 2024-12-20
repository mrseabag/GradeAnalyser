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

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database123";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {
        require_once 'vendor/autoload.php';

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file);
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        $existingIds = array();

        $existingIdsQuery = "SELECT id FROM test";
        $existingIdsResult = $conn->query($existingIdsQuery);

        if ($existingIdsResult->num_rows > 0) {
            while ($row = $existingIdsResult->fetch_assoc()) {
                $existingIds[] = $row["id"];
            }
        }

        $newEntriesCount = 0;
        $duplicateEntriesCount = 0;

        for ($row = 2; $row <= $highestRow; $row++) {
            $id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

            if (in_array($id, $existingIds)) {
                $duplicateEntriesCount++;
                continue;
            }

            $name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $age = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $country = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $english_hl = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $math_aasl = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            $computer_science_hl = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
            $french = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
            $business = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
            $health_science = $worksheet->getCellByColumnAndRow(10, $row)->getValue();

            $sql = "INSERT INTO test (id, name, age, country, english_hl, math_aasl, computer_science_hl, french, business, health_science) VALUES ('$id', '$name', '$age', '$country', '$english_hl', '$math_aasl', '$computer_science_hl', '$french', '$business', '$health_science')";

            if ($conn->query($sql) !== true) {
                echo "Error inserting row " . $row . ": " . $conn->error;
            } else {
                $newEntriesCount++;
            }
        }

        echo "<script>alert('Import successful! Added $newEntriesCount new entries. Skipped $duplicateEntriesCount duplicate entries.');</script>";
    } else {
        echo "<script>alert('No file selected.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <h1>Import Data</h1>
            <form method="POST" enctype="multipart/form-data">
                <p>Select an Excel file to import:</p>
                <input type="file" name="file" accept=".xlsx, .xls">
                <div class="button-container">
                    <button type="submit" name="import">Import</button>
                </div>
            </form>
            <div class="button-container">
                <button onclick="goBack()">Go Back</button>
            </div>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
