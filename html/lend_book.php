<?php
include 'db_connect.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the book ID and borrower details (assuming these are part of the form)
    $bookID = intval($_POST['book_id']);  // Ensure the book ID is an integer
    $borrowerName = $conn->real_escape_string(trim($_POST['borrower_name']));

    // Validate inputs
    if (empty($bookID) || empty($borrowerName)) {
        $error = "Book ID and borrower name are required.";
    } else {
        // Update the book status in the database (assuming a 'Borrowed' status)
        $sql = "UPDATE Book SET Status = 'Borrowed' WHERE BookID = $bookID";
        
        if ($conn->query($sql) === TRUE) {
            $success = "Book successfully borrowed by $borrowerName.";
        } else {
            $error = "Error borrowing book: " . $conn->error;
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
                <li><a href="./lend_book.php"><strong>Lend Book</strong></a></li>
                <li><a href="./return_book.php">Return Book</a></li>
                <li><a href="./insert_book.php">Insert Book</a></li>
                <li><a href="./contact.php">Contact Us</a></li>
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
        <form method="POST" action="lend_book.php">
            <div class="form-group">
                <label for="book_id">Book ID:</label>
                <input type="number" class="form-control" id="book_id" name="book_id" required>
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
