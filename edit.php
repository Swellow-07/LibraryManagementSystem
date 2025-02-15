<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookdatab";  // Make sure this is your correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the book id from the URL
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch the current book data
    $query = "SELECT * FROM book_inventory WHERE id = $book_id";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $book_name = $book['book_name'];
        $current_count = $book['count'];
    } else {
        echo "Book not found.";
        exit();
    }
}

// Update the quantity if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['new_quantity'])) {
        $new_quantity = $_POST['new_quantity'];

        // Ensure quantity is a number
        if (!is_numeric($new_quantity)) {
            echo "<script>alert('Quantity must be a number');</script>";
            exit();
        }

        // Update the book's quantity in the database
        $updateQuery = "UPDATE book_inventory SET count = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ii", $new_quantity, $book_id);

        if ($stmt->execute()) {
            echo "<script>alert('Book quantity updated successfully'); window.location.href = 'record.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter a valid quantity');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book Quantity</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .form-container {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Book Quantity</h2>
        
        <form method="POST">
            <label for="book_name">Book Name:</label>
            <input type="text" name="book_name" value="<?php echo $book_name; ?>" disabled><br>

            <label for="current_quantity">Current Quantity:</label>
            <input type="text" name="current_quantity" value="<?php echo $current_count; ?>" disabled><br>

            <label for="new_quantity">New Quantity:</label>
            <input type="number" name="new_quantity" required min="1"><br>

            <input type="submit" value="Update Quantity">
        </form>
    </div>
</body>
</html>
