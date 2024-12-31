<?php
include 'db_connect.php';

$sql = "SELECT CategoryID, Name FROM Category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["CategoryID"] . "'>" . htmlspecialchars($row["Name"]) . "</option>";
    }
} else {
    echo "<option disabled>No categories available</option>";
}

$conn->close();
?>
