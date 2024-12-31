<?php
include 'db_connect.php';

$searchTerm = isset($_GET["query"]) ? $conn->real_escape_string($_GET["query"]) : ''; // Get search query from URL or form

// Query the database for books that match the search term
$sql = "SELECT * FROM Book WHERE Title LIKE '%$searchTerm%'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($row["Title"]) . "</h3>";
        echo "<p>" . htmlspecialchars($row["Description"]) . "</p>";
        echo "<p>Year: " . $row["YearOfPublication"] . "</p>";
        echo "</div>";
    }
} else {
    echo "No books found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <!-- Brand/logo -->
            <div class="navbar-header">
                <a class="navbar-brand" href="#">e-Books</a>
            </div>
            <!-- Navigation links -->
            <ul class="nav navbar-nav">
                <li><a href="./index.html">Home</a></li>
                <li>
                    <input 
                        type="text" 
                        class="form-control navbar-input" 
                        placeholder="Search here" 
                        style="margin-top: 8px; margin-left: 10px; display: inline-block; width: auto;">
                </li>
                <li><a href="./lend_book.html">Lend Book</a></li>
                <li><a href="./return_book.html">Return Book</a></li>
                <li><a href="./insert_book.html">Insert Book</a></li>
                <li><a href="./contact.html">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    
</body>