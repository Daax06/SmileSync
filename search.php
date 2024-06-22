<!DOCTYPE html>
<html>
<head>
    <title>Search Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('dentist_background.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
        .container {
            max-width: 1000px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Result</h1>
        <table>
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $search_name = $_POST['search_name'];

                    $query = "SELECT * FROM Patient WHERE PatientName LIKE '%$search_name%'";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['PatientID'] . "</td>";
                            echo "<td>" . $row['PatientName'] . "</td>";
                            echo "<td>" . $row['Age'] . "</td>";
                            echo "<td>" . $row['Gender'] . "</td>";
                            echo "<td>" . $row['Address'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No patients found</td></tr>";
                    }
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>