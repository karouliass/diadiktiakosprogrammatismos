<?php
// Include the database connection
include 'db_connect.php';

// Initialize a variable to store search results
$searchResults = [];

// Check if there's a search query
if (isset($_GET['query'])) {
    $searchTerm = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT * FROM Book WHERE Title LIKE '%$searchTerm%'";
    $result = $conn->query($sql);
    
    // Fetch results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
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
                    <li><a href="./index.php"><strong>Home</strong></a></li>
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

    <div class="container">
        <h2>Best Sellers</h2>

        <?php if (!empty($searchResults)): ?>
            <div class="row">
                <?php foreach ($searchResults as $book): ?>
                    <div class="col-md-4">
                        <h3><?php echo htmlspecialchars($book["Title"]); ?></h3>
                        <p><?php echo htmlspecialchars($book["Description"]); ?></p>
                        <p>Year: <?php echo $book["YearOfPublication"]; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (isset($_GET['query'])): ?>
            <p>No books found for your search.</p>
        <?php else: ?>
            <div class="row">
                <div class="col-md-4">
                    <h3>Το Γκρούφαλο</h3>
                    <img src="../to_groufalo.png" alt="To groufalo" class="img-responsive" style="margin: 0 auto;">
                </div>
                <div class="col-md-4">
                    <h3>Βρες Με!</h3>
                    <img src="../vres_me_ora_gia_ypno.png" alt="Vres me" class="img-responsive" style="margin: 0 auto;">
                </div>
                <div class="col-md-4">
                    <h3>Κούκου τσα</h3>
                    <img src="../koukou_tsa_lios.png" alt="Koukou tsa" class="img-responsive" style="margin: 0 auto;">
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
