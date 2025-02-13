<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookdatab";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = "SELECT * FROM book_inventory";
$result = $conn->query($query);


if ($result->num_rows > 0) {
  
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['book_name']}</td>
                <td>{$row['count']}</td>
                <td>{$row['date']}</td>
              </tr>";
    }
} else {
   
    echo "<tr><td colspan='4'>No records found</td></tr>";
}

$conn->close();
?>
