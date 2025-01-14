<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $year = intval($_POST["year"]);
    $copies = intval($_POST["copies"]);
    $condition = $_POST["condition"];
    $categories = isset($_POST["categories"]) ? $_POST["categories"] : []; // Ensure categories exist

    $errors = [];

    // Validate inputs and add specific error messages
    if (empty($title)) {
        $errors[] = "Title is required.";
    }
    if (empty($description)) {
        $errors[] = "Description is missing.";
    }
    if ($year < 1900 || $year > 2024) {
        $errors[] = "Year must be between 1900 and 2024.";
    }
    if ($copies <= 0) {
        $errors[] = "Number of copies must be greater than 0.";
    }
    if (empty($categories) || count($categories) < 1 || count($categories) > 3) {
        $errors[] = "You must select between 1 and 3 categories.";
    }

    // If errors exist, redirect back with the error messages
    if (!empty($errors)) {
        $error_message = implode(" ", $errors); // Combine errors into a single string
        header("Location: insert_book.php?error=" . urlencode($error_message));
        exit;
    }

    // Start a transaction
    $conn->begin_transaction();
    try {
        // Insert book into the Book table
        $stmt = $conn->prepare("INSERT INTO Book (Title, Description, YearOfPublication, NumberOfCopies, cond) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiis", $title, $description, $year, $copies, $condition); 
        $stmt->execute();

        $bookID = $conn->insert_id; // Get the ID of the inserted book

        // Insert categories into the BookCategory table
        $stmt = $conn->prepare("INSERT INTO BookCategory (BookID, CategoryID) VALUES (?, ?)");
        foreach ($categories as $categoryID) {
            $categoryID = intval($categoryID); // Ensure it's numeric
            $stmt->bind_param("ii", $bookID, $categoryID);
            $stmt->execute();
        }

        // Commit the transaction
        $conn->commit();
        header("Location: insert_book.php?success=1");
        exit;
    } catch (Exception $e) {
        // Roll back the transaction on error
        $conn->rollback();
        error_log("Error inserting book: " . $e->getMessage()); // Log the error
        $error = "An error occurred while adding the book. Please try again.";
        header("Location: insert_book.php?error=" . urlencode($error));
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="insert_book.js"></script>
    <title>Insert Book</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="js/form-validation.js" defer></script>
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
                <li><a href="./lend_book.php">Lend Book</a></li>
                <li><a href="./return_book.php">Return Book</a></li>
                <li><a href="./insert_book.php"><strong>Insert Book</strong></a></li>
                <li><a href="./contact.php" class="active">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_GET["success"])): ?>
            <div class="alert alert-success">
                Book inserted successfully!
            </div>
        <?php elseif (isset($_GET["error"])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_GET["error"]); ?>
            </div>
        <?php endif; ?>

        <form id="insertBookForm" method="POST" action="insert_book.php" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" maxlength="300"></textarea>
            </div>
            <div class="form-group">
                <label for="year">Year of Publication:</label>
                <input type="number" class="form-control" id="year" name="year">
            </div>
            <div class="form-group">
                <label for="copies">Number of Copies:</label>
                <input type="number" class="form-control" id="copies" name="copies">
            </div>
            <div class="form-group">
                <label for="condition">Condition:</label>
                <select class="form-control" id="condition" name="condition">
                    <option value="New">New</option>
                    <option value="Used">Used</option>
                    <option value="Unknown">Unknown</option>
                </select>
            </div>
            <div class="form-group">
                <label>Categories:</label>
                <div class="checkbox">
            <label><input type="checkbox" name="categories[]" value="1"> Fiction</label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="categories[]" value="2"> Non-Fiction</label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="categories[]" value="3"> Science</label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" name="categories[]" value="4"> History</label>
        </div>
</div>

            <button type="submit" class="btn btn-primary">Insert Book</button>
        </form>
    </div>
</body>
</html>