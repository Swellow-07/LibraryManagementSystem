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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record of Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }

        .edit-btn {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Available Books in the Library</h1>
    
    <!-- Table to display books -->
    <table>
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Book Name</th>
                <th>Available Quantity</th>
                <th>Date</th>
                <th>Edit Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $available_count = ($row['count'] > 0) ? $row['count'] : 0;
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['book_name'] . "</td>";
                    echo "<td>" . $available_count . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td><a href='edit.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="donate.html">Donate Books</a>
    <a href="borrow.html">Borrow Books</a>
    
    <?php
    $conn->close();
    ?>
</body>
</html>
