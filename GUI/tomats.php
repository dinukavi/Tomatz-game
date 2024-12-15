<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    print('$username');
    exit();
}
  
// Database connection parameters
$server_name = "localhost";
$user_name = "root";
$password = "";
$database = "game2";

// Establish connection to the database
$conn = new mysqli($server_name, $user_name, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to fetch the user's highest score
$sql_fetch_highest_score = "SELECT highest_score FROM users WHERE user_name = ?";
$stmt = $conn->prepare($sql_fetch_highest_score);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) 
{
    // User record exists, update highest score
    $stmt->bind_result($highest_score);
    $stmt->fetch();
    $stmt->close();

    // Set the current score from session data
    $current_score = isset($_SESSION['highest_score']) ? $_SESSION['highest_score'] : 0;

    if ($current_score > $highest_score) {
        $highest_score = $_COOKIE["highestscore"];
        echo "highestscore" . $highest_score;
        // Update the highest score in the database
        $sql_update_score = "UPDATE users SET highest_score = ? WHERE user_name = ?";
        $stmt_update = $conn->prepare($sql_update_score);
        $stmt_update->bind_param("si", $current_score, $_SESSION['username']);
        $stmt_update->execute();
        $stmt_update->close();
    }
} else {
    // Insert a new record for the user with the current score as the highest score
    $sql_insert_user = "INSERT INTO users (user_name, highest_score) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert_user);
    $current_score = isset($_SESSION['highest_score']) ? $_SESSION['highest_score'] : 0;
    $stmt_insert->bind_param("si", $_SESSION['username'], $current_score);
    $stmt_insert->execute();
    $stmt_insert->close();
}

function updatehighestscore()
{
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $database = "game2";

    $conn = new mysqli($server_name, $user_name, $password, $database);

    $highest_score = $_COOKIE["highestscore"];
        echo "highestscore" . $highest_score;
        // Update the highest score in the database
        $sql_update_score = "UPDATE users SET highest_score = ? WHERE user_name = ?";
        $stmt_update = $conn->prepare($sql_update_score);
        $stmt_update->bind_param("si", $current_score, $_SESSION['username']);
        $stmt_update->execute();
        $stmt_update->close();
}

// Close the database connection
$conn->close();
?>






<!DOCTYPE html>

<html lang="en-gb">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="GENERATOR" content="A plain text editor">
    <meta name="Author" content="Marc Conrad">
    <meta name="Description" content="Tomato Game Demo">


    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="../STYLING/cascading.css">


    <title>The Tomats Game</title>
    <style>
        h1 {
            color: blue;
        }

        .button-62 {
            background: linear-gradient(to bottom right, #EF4765, #FF9A5A);
            border: 0;
            border-radius: 12px;
            color: #FFFFFF;
            cursor: pointer;
            display: inline-block;
            font-family: -apple-system, system-ui, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 2.5;
            outline: transparent;
            padding: 0 1rem;
            text-align: center;
            text-decoration: none;
            transition: box-shadow .2s ease-in-out;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
        }

        .h2-62 {
            line-height: 2.5;
        }


        .button-62:not([disabled]):focus {
            box-shadow: 0 0 .25rem rgba(0, 0, 0, 0.5), -.125rem -.125rem 1rem rgba(239, 71, 101, 0.5), .125rem .125rem 1rem rgba(255, 154, 90, 0.5);
        }

        .button-62:not([disabled]):hover {
            box-shadow: 0 0 .25rem rgba(0, 0, 0, 0.5), -.125rem -.125rem 1rem rgba(239, 71, 101, 0.5), .125rem .125rem 1rem rgba(255, 154, 90, 0.5);
        }


        /* Styles for the result box */
        .result-box {
            position: absolute;
            top: 50%;
            left: 45%;
            transform: translate(-50%, -50%);
            background-color: aquamarine;
            padding: 20px;
            border: 2px solid #000;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
            display: none;
            /* Initially hidden */
            color: #FFFFFF;
            width: 250px;
            height: 400px;
            align-content: center;
            border-radius: 10px;
            border-width: 5px;

        }

        .result-box h1 {
            margin-top: 0;
            align-items: center;
            -webkit-text-stroke: #FF9A5A;
            -webkit-text-fill-color: #EF4765;
        }

        .result-box p {
            margin-top: 0;
            font-size: 15px;
            align-items: center;
            color: black;
        }
    </style>

</head>

<body>
    <script>
        startup();
    </script>

    
    <!--/*used the marcconrad.com tomato api source codes from here*/-->
    <div class="container" style="left:22%; right:56%; top: 17%; bottom: 10%; width:45%; height:75%">
        <img id="quest" />
        <h2>Enter the missing digit: <input class="button-62" id="input" type="number" step="1" min="0" max="9">
            <button onclick="handleInput()" class="button-62">Verify</button>
        </h2><!-- Add the Verify button -->
        <h2 class="h2-62" id="note">[Wait for first game]</h2>
    </div>


    <div class="container" style="left: 75%; right: 10%; top: 0%; bottom: 50%; background:transparent">
        <br>
        <h3 style="text-align: center; color:green; -webkit-text-stroke: 0.3px blue; -webkit-text-fill-color:yellow;" ;>Hello, <?php echo $_SESSION['username']; ?>!</h3>

        <h2 id="timer">Time left: 15s</h2>

        <script>
            var quest = "";
            var solution = -1;
            var timeLeft = 15;
            var score = 0;
            var correctAnswers = 0;
            var timerInterval;
            var highestScore = <?php echo json_encode($highest_score); ?>;


            let newgame = function(x) {
                startup();
            }

            let verify = function() { // Function to verify the entered digit
                handleInput();
            }


            let handleInput = function() {
                let inp = document.getElementById("input").value;
                var note = document.getElementById("note");
                if (inp == solution) {
                    score += 10; // Score 10 points for each correct answer
                    correctAnswers++; // Increment correct answers count
                    // Update highest score if current score surpasses it
                    if (score > highestScore) {
                        highestScore = score;

                        document.cookie = "highestscore=" + highestScore;
                    
                        updateHighestScore();
                    }
                    note.innerHTML = 'Correct! -  <button class="button-62" onClick="newgame()" >New game?</button>';
                    document.getElementById("score").innerHTML = "Score: " + score; // Update the displayed score
                } else {
                    note.innerHTML = "Not Correct!";
                }
            }


            let startQuest = function(data) {
                var parsed = JSON.parse(data);
                quest = parsed.question;
                solution = parsed.solution;
                let img = document.getElementById("quest");
                img.src = quest;
                let note = document.getElementById("note");
                note.innerHTML = "Quest is ready.";
            }

            let fetchText = async function() {
                let response = await fetch('https://marcconrad.com/uob/tomato/api.php');
                let data = await response.text();
                startQuest(data);
            }

            let startup = function() {
                fetchText();
                startTimer();
            }
/*end of the marcconrad.com tomato api source codes */

            let startTimer = function() {
                let timerDisplay = document.getElementById("timer");
                timerInterval = setInterval(function() {
                    timeLeft--;
                    timerDisplay.textContent = "Time left: " + timeLeft + "s";
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        timerDisplay.textContent = "Time's up!";
                        // Display final score and correct answers count
                        displayFinalScore();
                    }
                }, 1000); // Update timer every 1 second
            }

            console.log("score ", score);
            console.log("highestScore ", highestScore);

            document.cookie = "highestscore=" + highestScore;

            let displayFinalScore = function() {
                let resultBox = document.getElementById("result-box");
                let finalScoreElement = document.getElementById("final-score");
                let correctAnswersElement = document.getElementById("correct-answers");
                let highestScoreElement = document.getElementById("highest-score");


                finalScoreElement.textContent = score;
                correctAnswersElement.textContent = correctAnswers;
                highestScoreElement.textContent = highestScore; // Display the highest score

                resultBox.style.display = "block";

            }

        function updateHighestScore() {
            let highestScore = document.cookie.replace(/(?:(?:^|.*;\s*)highestscore\s*\=\s*([^;]*).*$)|^.*$/, "$1");
            console.log("Updating score to:", highestScore); // Debugging line to see what's sent

            fetch('../CODE/updateHighestScore.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: "highestscore=" + encodeURIComponent(highestScore)
            })
            .then(response => response.text())
            .then(data => {
                console.log("Response from server:", data); // Debugging line to see server response
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

            // Start the game when the page loads
            startup();
            
        </script>


        <img src="../images/OIP-removebg-preview.png" height="170px" width="170px">
        <br>
        <a href="../CODE/logout.php">
            <button style="font-size: 30px; background-color: black; border-radius: 25px;" type="button" class="btn btn-primary"><b>Logout</b></button>
        </a>

        <br><br>
        <a href="../GUI/ongamehelp.php">
            <button style="font-size: 30px; background-color: black; border-radius: 25px;" type="button" class="btn btn-primary"><b>Help</b></button>
        </a>
        <br><br>
        <a href="../GUI/game.php">
            <button style="font-size: 30px; background-color: black; border-radius: 25px;" type="button" class="btn btn-primary"><b>Exit</b></button>
        </a>
    </div>

    <!-- Result box for displaying final score and correct answers -->
    <div class="result-box" id="result-box" style="display: none; text-align: center; ">
        <h1>Game Over</h1>
        <img src="../images/sad-tomato.png" height="170px" width="170px">
        <p>Final Score: <span id="final-score"></span></p>
        <p>Correct Answers: <span id="correct-answers"></span></p>
        <p>Highest Score: <span id="highest-score"></span></p>
<br>
        <a href="../GUI/tomats.php">
            <button type="submit">New Game</button>
        </a>
        <a href="../GUI/game.php">
            <button type="button">Exit</button>
        </a>
    </div>

<br>





</body>

</html>