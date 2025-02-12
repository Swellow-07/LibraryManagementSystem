<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_name = trim($_POST['book_name']); // Trim any spaces
    $student_id = $_POST['student_id'];

    // Debugging: Print the book name and student ID to ensure they're passed correctly
    echo "Book name: " . $book_name . "<br>";
    echo "Student ID: " . $student_id . "<br>";

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT num_books FROM borrowed_books WHERE book_name = ?");
    $stmt->bind_param("s", $book_name);

    // Check if the query runs successfully
    if (!$stmt->execute()) {
        echo "<script>alert('Error executing query');</script>";
    } else {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_books = $row['num_books'];

            if ($current_books > 0) {
                // Decrease the number of books in the records
                $stmt = $conn->prepare("UPDATE borrowed_books SET num_books = num_books - 1 WHERE book_name = ?");
                $stmt->bind_param("s", $book_name);
                $stmt->execute();
                echo "<script>alert('Book borrowed successfully by Student ID: $student_id');</script>";
            } else {
                echo "<script>alert('No books available');</script>";
            }
        } else {
            echo "<script>alert('Book not found');</script>";
        }
    }

    $stmt->close();
}
$conn->close();
?>

<form method="post">
    Student ID: <input type="text" name="student_id" required><br>
    Book Name: <input type="text" name="book_name" required><br>
    <input type="submit" value="Borrow Book">
</form>
