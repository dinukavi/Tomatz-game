<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="../STYLING/cascading.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border-bottom-style: dotted;
        }

        th, td {
            text-align: center;
            padding: 8px;
        }

        th {
            background-color:crimson;
        }

        tr:nth-child(even) {
            background-color: #245;
        }
    </style>
</head>
<body>
    <div class="container" >
        <h1 class="tomatz">Leaderboard</h1>

        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>User Name</th>
                    <th>Highest Score</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $server_name = "localhost";
                $user_name = "root";
                $password = "";
                $database = "game2";

                // Create connection
                $conn = new mysqli($server_name, $user_name, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to select top 5 users by highest_score
                $sql = "SELECT user_name, highest_score FROM users ORDER BY highest_score DESC LIMIT 5";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $rank = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $rank . "</td>";
                        echo "<td>" . $row["user_name"] . "</td>";
                        echo "<td>" . $row["highest_score"] . "</td>";
                        echo "</tr>";
                        $rank++;
                    }
                } else {
                    echo "<tr><td colspan='3'>0 results</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>

<br>
        <a href="../GUI/game.php">
            <button style="font-size: 30px; background-color:crimson; border-radius: 5px;" type="button" class="btn btn-primary"><b>OK</b></button>
        </a>
    </div>
</body>
</html>

