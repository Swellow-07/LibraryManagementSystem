<?php
include 'db.php'; 

$sql = "SELECT * FROM records";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Records</title>
</head>
<body>
    <h2>Book Records</h2>
    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Book Name</th>
            <th>Number of Books</th>
            <th>Date Donated</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["student_id"]; ?></td>
                <td><?php echo $row["book_name"]; ?></td>
                <td><?php echo $row["num_books"]; ?></td>
                <td><?php echo $row["borrow_date"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>