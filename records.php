<?php
include('db.php');

$sql = "SELECT * FROM borrowed_books";
$result = $conn->query($sql);
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Books</th>
        <th>Number</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['book_name']; ?></td>
        <td><?php echo $row['num_books']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php $conn->close(); ?>
