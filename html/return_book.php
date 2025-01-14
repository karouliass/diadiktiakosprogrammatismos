<?php
include 'db_connect.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string(trim($_POST['book_title']));
    $borrowerName = $conn->real_escape_string(trim($_POST['borrower_name']));

    // Validate inputs
    if (empty($title) || empty($borrowerName)) {
        $error = "Book Title and borrower Name are required.";
    } else {
        // Check if the book is available
        $checkQuery = "SELECT * FROM Book WHERE Title = '$title'";
        $result = $conn->query($checkQuery);

        if ($result && $result->num_rows > 0) {
            $book = $result->fetch_assoc();
            $bookID = $book['BookID'];

            // Transaction to ensure consistency
            $conn->begin_transaction();
            try {
                // Decrement book copies
                $updateQuery = "UPDATE Book SET NumberOfCopies = NumberOfCopies + 1 WHERE BookID = $bookID";
                $conn->query($updateQuery);
                $conn->commit();
            } catch (Exception $e) {
                $conn->rollback();
                $error = "Error returning book: " . $conn->error;
            }
        } else {
            $error = "Error returning book: ";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Book</title>
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
                    <li><a href="./return_book.php"><strong>Return Book</strong></a></li>
                    <li><a href="./insert_book.php">Insert Book</a></li>
                    <li><a href="./contact.php" class="active">Contact Us</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Book lending form -->
        <form method="POST" action="return_book.php">
            <div class="form-group">
                <label for="book_title">Book Title:</label>
                <input type="text" class="form-control" id="book_title" name="book_title" required>
            </div>
            <div class="form-group">
                <label for="borrower_name">Borrower Name:</label>
                <input type="text" class="form-control" id="borrower_name" name="borrower_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Return Book</button>
        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
</body>