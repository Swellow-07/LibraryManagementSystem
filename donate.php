<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['book_name']) && !empty($_POST['student_id'])) {
        $student_id = $_POST['student_id'];
        $book_name = $_POST['book_name'];

        // Check if book exists
        $stmt = $conn->prepare("SELECT num_books FROM borrowed_books WHERE book_name = ?");
        $stmt->bind_param("s", $book_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_books = $row['num_books'];

            if ($current_books < 5) {
                // Update book count
                $stmt = $conn->prepare("UPDATE borrowed_books SET num_books = num_books + 1 WHERE book_name = ?");
                $stmt->bind_param("s", $book_name);
                if ($stmt->execute()) {
                    echo "<script>alert('Book donated successfully by Student ID: $student_id');</script>";
                } else {
                    echo "<script>alert('Error: " . $stmt->error . "');</script>";
                }
            } else {
                echo "<script>alert('Maximum amount of books reached');</script>";
            }
        } else {
            // Insert new book entry
            $stmt = $conn->prepare("INSERT INTO borrowed_books (book_name, num_books) VALUES (?, 1)");
            $stmt->bind_param("s", $book_name);
            if ($stmt->execute()) {
                echo "<script>alert('Book donated successfully by Student ID: $student_id');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter both Student ID and Book Name');</script>";
    }
}

$conn->close();
?>

<form method="post">
    Student ID: <input type="number" name="student_id" required><br>
    Book Name: <input type="text" name="book_name" required><br>
    <input type="submit" value="Donate Book">
</form>
