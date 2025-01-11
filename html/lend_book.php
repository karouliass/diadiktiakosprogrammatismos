<?php
include 'db_connect.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string(trim($_POST['Title'])); // Use the Title field as input
    $borrowerName = $conn->real_escape_string(trim($_POST['borrower_name'])); // Borrower name

    // Validate inputs
    if (empty($title) || empty($borrowerName)) {
        $error = "Book Title and borrower name are required.";
    } else {
        // Check if the book is available
        $checkQuery = "SELECT * FROM Book WHERE Title = '$title' AND NumberOfCopies > 0";
        $result = $conn->query($checkQuery);

        if ($result && $result->num_rows > 0) {
            $book = $result->fetch_assoc();
            $bookID = $book['BookID'];
            // Update the book's status and decrement copies
            $updateQuery = "UPDATE Book SET NumberOfCopies = NumberOfCopies - 1 WHERE BookID = $bookID";
            $result = $conn->query($updateQuery);
            $borrowerInfo = 'INSERT INTO contacts (Name, Role) VALUES ($borrowerName, "Guest")';
            $borrowResult = $conn->query($borrowerInfo);
            if ($result===TRUE ) {
                $success = "Book successfully borrowed by $borrowerName./nReturn Date: In two weeks!";
            } else {
                $error = "Error borrowing book: " . $conn->error;
            }

        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lend Book</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">e-Books</a>
            </div>
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
                <li><a href="./lend_book.php"><strong>Lend Book</strong></a></li>
                <li><a href="./return_book.php">Return Book</a></li>
                <li><a href="./insert_book.php">Insert Book</a></li>
                <li><a href="./contact.php" class="active">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Book Lending Form -->
        <form method="POST" action="lend_book.php">
            <div class="form-group">
                <label for="Title">Book Title:</label>
                <input type="text" class="form-control" id="Title" name="Title" required>
            </div>
            <div class="form-group">
                <label for="borrower_name">Borrower Name:</label>
                <input type="text" class="form-control" id="borrower_name" name="borrower_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Borrow Book</button>
        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
