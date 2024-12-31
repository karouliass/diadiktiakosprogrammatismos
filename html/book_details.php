<?php
include 'db_connect.php';

$bookID = $_GET["id"];
$sql = "SELECT * FROM Book WHERE BookID = $bookID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
    echo "<h1>" . $book["Title"] . "</h1>";
    echo "<p>" . $book["Description"] . "</p>";
    echo "<p>Year: " . $book["YearOfPublication"] . "</p>";
    echo "<p>Copies Available: " . $book["NumberOfCopies"] . "</p>";
    echo "<p>Condition: " . $book["Condition"] . "</p>";
} else {
    echo "Book not found.";
}

$conn->close();
?>
