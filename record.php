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
        #nav {
            position: fixed;
            right: 5vw;
            font-size: larger;
        }

        #logo {
            position: fixed;
            left: 5vw;
        }

        a {
            text-decoration: none;
            font-family:fantasy;
            color: black;
            border-width: 5px;
            font: bold;
            text-shadow: #333;
            font-style: oblique;        
        }
        .book-logo {
            position: relative;
            width: 50px;
            height: 60px;
            background-color: #e53935;
            border-radius: 8px 8px 4px 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .book-logo:hover {
            transform: scale(1.1);
        }

        .book-logo::before,
        .book-logo::after {
            content: "";
            position: absolute;
            top: 0px;
            width: 100%;
            height: 5px;
            background-color: #fff;
        }

        .book-logo::before {
            left: 0;
            border-radius: 4px 4px 0 0;
        }

        .book-logo::after {
            bottom: 10px;
            border-radius: 0 0 4px 4px;
        }

        .book-logo .book-spine {
            position: absolute;
            top: 0;
            left: 0;
            width: 12px;
            height: 100%;
            background-color: #333;
            border-radius: 4px 0 0 4px;
        }

        .book-link {
            display: block;
            width: 100%;
            height: 100%;
            text-decoration: none;
        }

        .link:hover {
            color: white;
            border-color: whitesmoke;
            background-color: #DFCAA0;
        }
        .innercontainer{
            width: 80%;
            height: 80%;
            background-color:#DFCAA0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.2), 0px 5px 10px rgba(0, 0, 0, 0.2);
        }
        .image,.record{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .record{
            height: 60%;
            background-color: #C8AD7E;
            width: 60%;
            position: absolute;
            opacity: 80%;

            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
        .table1{
            position: absolute;
            font-size:larger;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            }
        table,th,td{
            border:5px solid whitesmoke ;
            border-collapse: collapse;
            background-color: #C8AD7E;
            padding: 1vw;
        }
        .edit{
            color: #333;
            padding: 1vh;
            border-radius: 1vh;
            font-size: large;
            background-color: wheat;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .edit:hover{
            color: black;
            background-color: beige;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body style="box-sizing: border-box; background: #F6E3BA;">
    <div style="height: 10px; background-color: #C8AD7E;box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);"></div>
    <span id="MINERVA" style="position: absolute; left: 10%;">
        <h1 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color: black;font-size: 2.2vw;">MINERVA
            LIBRARY</h1>
    </span>
    <div id="nav">
        <nav>
            <ul>
                <span id="logo"><a href="index.html" class="book-link">
                        <div class="book-logo">
                            <div class="book-spine"></div>
                            HHOME
                        </div>
                    </a></span>
                <a href="donate.html" class="link"><u>Donate</u> &nbsp;</a>
                <a href="borrow.html" class="link"><u>Borrow</u> &nbsp;</a>
                <a href="record.html" class="link"><u>Records</u> &nbsp;</a>
                <a href="login.html" class="link"><u>Account</u> &nbsp;</a>
            </ul>
        </nav>
    </div>
    <div style="position:relative; top: 8vh;  opacity: 85%;text-align: center;left: auto;right: auto;
    border-top: 10px solid #C8AD7E;width: 100%;height: 85vh; 
    box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.2), 0px 5px 10px rgba(0, 0, 0, 0.2); background-color: #FFEFCB;
    display: flex;align-items: center;justify-content: center;">

    <h1 style="position: absolute;top: 0;"><u>RECORDS</u></h1>
    <div class="innercontainer">
    <div class="image">
        <img src="homepage.jpg" alt="bg" style="width: 90%;border-radius: 10px;">
            <h2 style="position: absolute;color: whitesmoke;top: 14%;">MINERVA</h2>
            <div class="record">
                <table class="table1">
                    <thead>
                        <tr>
                            <th scope="col">Book ID</th>
                            <th scope="col">Book Name</th>
                            <th scope="col">Available Quantity</th>
                            <th scope="col">Date</th>
                            <th scope="col">Edit Quantity</th>
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
                                echo "<td><a href='edit.php?id=" . $row['id'] . "' class='edit'>Edit</a></td>";
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
    </div>
    </div>
    </div>

    </div>
</body>
</html>
