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
                    <li><a href="./index.php">Home</a></li>
                    <li>
                        <form class="navbar-form" method="GET" action="search_books.php">
                            <div class="form-group">
                                <label for="search-bar" class="sr-only">Search</label>
                                <input 
                                    type="text" 
                                    id="search-bar" 
                                    name="query"
                                    class="form-control" 
                                    placeholder="Search here">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>
                    </li>
                    <li><a href="./lend_book.php">Lend Book</a></li>
                    <li><a href="./return_book.php">Return Book</a></li>
                    <li><a href="./insert_book.php">Insert Book</a></li>
                    <li><a href="./contact.php" class="active">Contact Us</a></li>
                </ul>
            </div>
        </nav>

</body>