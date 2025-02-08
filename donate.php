<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "bookdatab";  


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$studentid = $_POST['studentid'];  
$bookname = $_POST['bookname'];
$number = $_POST['number'];
$date = $_POST['date'];


$sql = "INSERT INTO `records` (`student_id`, `book_name`, `num_books`, `borrow_date`) 
        VALUES ('$studentid', '$bookname', '$number', '$date')";

if ($conn->query($sql) === TRUE) {
    echo "Book donated successfully!";
} else {
    echo "Error: " . $conn->error;
}


$conn->close();
?>