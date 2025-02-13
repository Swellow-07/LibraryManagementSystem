<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['studentid']) && !empty($_POST['bookname']) && !empty($_POST['quantity'])) {
        $student_id = $_POST['studentid'];
        $book_name = $_POST['bookname'];
        $quantity = $_POST['quantity'];

        // Ensure quantity is a number
        if (!is_numeric($quantity)) {
            echo "<script>alert('Quantity must be a number');</script>";
            exit();
        }

        // Add your donation logic here (insert into db or update counts)
        // For example:
        $stmt = $conn->prepare("UPDATE book_inventory SET count = count + ? WHERE book_name = ?");
        $stmt->bind_param("is", $quantity, $book_name);
        if ($stmt->execute()) {
            echo "<script>alert('Book donated successfully by Student ID: $student_id');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter all fields');</script>";
    }
}

$conn->close();
?>
