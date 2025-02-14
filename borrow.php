<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookdatab"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $book_name = $_POST['book_name'];
    $student_id = $_POST['student_id'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];

 
    $checkQuery = "SELECT count FROM book_inventory WHERE book_name = '$book_name'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();
        $current_quantity = $row['count'];

        if ($current_quantity >= $quantity) {
           
            $new_quantity = $current_quantity - $quantity;
            $updateQuery = "UPDATE book_inventory SET count = $new_quantity WHERE book_name = '$book_name'";
            
            if ($conn->query($updateQuery) === TRUE) {
            

                echo "Book borrowed successfully. <br>";
                echo "Book Name: $book_name<br>";
                echo "Student ID: $student_id<br>";
                echo "Quantity Borrowed: $quantity<br>";
                echo "Date: $date<br>";
                header("Location: record.php"); 
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

$conn->close();
?>
