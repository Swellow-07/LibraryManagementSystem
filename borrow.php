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

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $book_name = $_POST['book_name'];
    $student_id = $_POST['student_id'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];

    // Check if the book exists in the inventory and has enough stock
    $checkQuery = "SELECT count FROM book_inventory WHERE book_name = '$book_name'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Get the current quantity of the book
        $row = $result->fetch_assoc();
        $current_quantity = $row['count'];

        if ($current_quantity >= $quantity) {
            // Update the quantity in the database
            $new_quantity = $current_quantity - $quantity;
            $updateQuery = "UPDATE book_inventory SET count = $new_quantity WHERE book_name = '$book_name'";
            
            if ($conn->query($updateQuery) === TRUE) {
                // Insert record into borrow history (if required)
                // $insertQuery = "INSERT INTO borrow_history (book_name, student_id, quantity, date) VALUES ('$book_name', '$student_id', '$quantity', '$date')";
                // $conn->query($insertQuery);

                echo "Book borrowed successfully. <br>";
                echo "Book Name: $book_name<br>";
                echo "Student ID: $student_id<br>";
                echo "Quantity Borrowed: $quantity<br>";
                echo "Date: $date<br>";
                header("Location: record.php"); // Redirect to the records page after borrowing
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Not enough books available. Current quantity: $current_quantity";
        }
    } else {
        echo "Book not found in inventory.";
    }
}

// Close connection
$conn->close();
?>
