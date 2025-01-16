<?php
include 'db_connect.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $title = isset($_POST['title']) ? $conn->real_escape_string(trim($_POST['title'])) : '';
    $borrowerName = isset($_POST['borrower_name']) ? $conn->real_escape_string(trim($_POST['borrower_name'])) : '';

    // Validate inputs
    if (empty($title) || empty($borrowerName)) {
        $error = "Book Title and Borrower Name are required.";
    } else {
        // Check if the book is available (at least one copy)
        $checkQuery = "SELECT * FROM `book` WHERE `Title` = '$title' AND `NumberOfCopies` > 0";
        $result = $conn->query($checkQuery);

        if ($result && $result->num_rows > 0) {
            $book = $result->fetch_assoc();
            $bookID = $book['BookID'];

            // Begin a transaction for consistency
            $conn->begin_transaction();
            try {
                // Decrease the number of available copies of the book
                $updateQuery = "UPDATE `book` SET `NumberOfCopies` = `NumberOfCopies` - 1 WHERE `BookID` = $bookID";
                if (!$conn->query($updateQuery)) {
                    throw new Exception("Error updating book copies: " . $conn->error);
                }

                // Insert borrow information directly with the borrower's name
                // Since contactId is not used, we directly store the borrower's name in the 'borrow' table
                $borrowInfo = "INSERT INTO `borrow` (`BookID`, `BorrowerName`, `ReturnDate`) VALUES ($bookID, '$borrowerName', NOW() + INTERVAL 2 WEEK)";
                if (!$conn->query($borrowInfo)) {
                    throw new Exception("Error inserting borrow information: " . $conn->error);
                }

                // Commit the transaction
                $conn->commit();
                
                // Success message, showing both the borrower's name and book's title
                $returnDate = date('Y-m-d', strtotime('+2 weeks'));
                $success = "Book '$title' successfully borrowed by $borrowerName. Return Date: $returnDate.";
            } catch (Exception $e) {
                // Rollback if there's an error and show detailed error message
                $conn->rollback();
                $error = "Error borrowing book: " . $e->getMessage();
            }
        } else {
            $error = "Book '$title' is not available or does not exist.";
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
                <label for="title">Book Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
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
