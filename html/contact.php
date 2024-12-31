<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Us</title>
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
                        <form class="navbar-form">
                            <div class="form-group">
                                <label for="search-bar" class="sr-only">Search</label>
                                <input 
                                    type="text" 
                                    id="search-bar" 
                                    class="form-control" 
                                    placeholder="Search here">
                            </div>
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
            <div class="contact-list">
                <ul class="list-unstyled">
                    <li><strong>Name:</strong> Theodoros Gkiliopoulos (TL20533)</li>
                    <li><strong>Name:</strong> Pavlos Antwnidakhs (TL20483)</li>
                    <li><strong>Name:</strong> Panagiwths Kouzhs (TL20411)</li>
                </ul>
            </div>
        </div>
    </body>
</html>
