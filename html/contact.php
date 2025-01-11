<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';

    // Check if the form submission is for adding a message or adding a contact
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
        // Handle message submission
        $name = $conn->real_escape_string($_POST["name"]);
        $email = $conn->real_escape_string($_POST["email"]);
        $message = $conn->real_escape_string($_POST["message"]);

        $sql = "INSERT INTO ContactMessages (Name, Email, Message) VALUES ('$name', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Message sent successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    } elseif (isset($_POST["new_contact_name"]) && isset($_POST["new_contact_role"])) {
        // Handle adding a new contact
        $new_contact_name = $conn->real_escape_string($_POST["new_contact_name"]);
        $new_contact_role = $conn->real_escape_string($_POST["new_contact_role"]);

        $sql = "INSERT INTO Contacts (Name, Role) VALUES ('$new_contact_name', '$new_contact_role')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "New contact added successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Us</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- Custom JavaScript for form validation -->
        <script src="js/form-validation.js" defer></script>
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
                    <li><a href="./contact.php" class="active"><strong>Contact Us</strong></a></li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container">
            <div class="jumbotron">
                <h1>Contact Information</h1>
                <p>Get in touch with our team:</p>
            </div>

            <!-- Display Success or Error Messages -->
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <!-- Contact List -->
            <div class="contact-list">
                <ul class="list-unstyled">
                    <li><strong>Name:</strong> Theodoros Gkiliopoulos (TL20533)</li>
                    <li><strong>Name:</strong> Pavlos Antwnidakhs (TL20483)</li>
                    <li><strong>Name:</strong> Panagiwths Kouzhs (TL20411)</li>
                    <?php
                    // Fetch additional contacts dynamically
                    include 'db_connect.php';
                    $sql = "SELECT Name, Role FROM Contacts WHERE Name NOT IN (
                        'Theodoros Gkiliopoulos', 'Pavlos Antwnidakhs', 'Panagiwths Kouzhs')";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<li><strong>Name:</strong> " . htmlspecialchars($row["Name"]) . " (" . htmlspecialchars($row["Role"]) . ")</li>";
                        }
                    }

                    $conn->close();
                    ?>
                </ul>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form id="messageForm" method="POST" action="contact.php">
                    <div class="form-group">
                        <label for="name">Your Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Your Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <!-- Add Contact Form -->
            <div class="add-contact-form">
                <h2>Add a New Contact</h2>
                <form id="contactForm" method="POST" action="contact.php">
                    <div class="form-group">
                        <label for="new_contact_name">Contact Name:</label>
                        <input type="text" class="form-control" id="new_contact_name" name="new_contact_name" required>
                    </div>
                    <div class="form-group">
                        <label for="new_contact_role">Role:</label>
                        <input type="text" class="form-control" id="new_contact_role" name="new_contact_role" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Contact</button>
                </form>
            </div>
        </div>
    </body>
</html>