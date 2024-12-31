<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string(trim($_POST["title"]));
    $description = $conn->real_escape_string(trim($_POST["description"]));
    $year = intval($_POST["year"]);
    $copies = intval($_POST["copies"]);
    $condition = $conn->real_escape_string($_POST["condition"]);
    $categories = $_POST["categories"]; // Array of selected categories

    // Validate input
    if (empty($title) || empty($description) || $year < 1900 || $year > 2024 || $copies <= 0 || empty($categories)) {
        $error = "Invalid form data. Please check your inputs.";
        header("Location: insert_book.php?error=" . urlencode($error));
        exit;
    }

    // Insert book into the Book table
    $sql = "INSERT INTO Book (Title, Description, YearOfPublication, NumberOfCopies, Condition)
            VALUES ('$title', '$description', $year, $copies, '$condition')";

    if ($conn->query($sql) === TRUE) {
        $bookID = $conn->insert_id; // Get the ID of the inserted book

        // Insert categories into the BookCategory table
        foreach ($categories as $categoryID) {
            $categoryID = intval($categoryID); // Ensure it's numeric
            $conn->query("INSERT INTO BookCategory (BookID, CategoryID) VALUES ($bookID, $categoryID)");
        }

        header("Location: insert_book.php?success=1");
        exit;
    } else {
        $error = "Error inserting book: " . $conn->error;
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
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">e-Books</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./lend_book.php">Lend Book</a></li>
                <li><a href="./return_book.php">Return Book</a></li>
                <li><a href="./insert_book.php"><strong>Insert Book</strong></a></li>
                <li><a href="./contact.php">Contact Us</a></li>
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
                <input type="text" class="form-control" id="title" name="title" onmouseover="showTooltip(this, 'Enter the title of the book.')">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" maxlength="300" onmouseover="showTooltip(this, 'Enter a description (max 300 characters).')"></textarea>
            </div>
            <div class="form-group">
                <label for="year">Year of Publication:</label>
                <input type="number" class="form-control" id="year" name="year" onmouseover="showTooltip(this, 'Enter the year (1900-2024).')">
            </div>
            <div class="form-group">
                <label for="copies">Number of Copies:</label>
                <input type="number" class="form-control" id="copies" name="copies" onmouseover="showTooltip(this, 'Enter the number of copies (must be > 0).')">
            </div>
            <div class="form-group">
                <label for="condition">Condition:</label>
                <select class="form-control" id="condition" name="condition" onmouseover="showTooltip(this, 'Select the condition of the book.')">
                    <option value="new">New</option>
                    <option value="good">Good</option>
                    <option value="worn">Worn</option>
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
