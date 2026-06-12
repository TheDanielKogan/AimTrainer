<!-- 
Daniel Kogan
March 24th, 2026
PHP file for the leaderboard
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/leaderboard.css">
</head>

<body>
    <?php
    include "connect.php";

    $mode = filter_input(INPUT_POST, "mode", FILTER_SANITIZE_SPECIAL_CHARS);
    $size = filter_input(INPUT_POST, "size", FILTER_SANITIZE_SPECIAL_CHARS);
    $time = filter_input(INPUT_POST, "time", FILTER_SANITIZE_SPECIAL_CHARS);
    $fade = filter_input(INPUT_POST, "fade", FILTER_SANITIZE_SPECIAL_CHARS);
    $score = filter_input(INPUT_POST, "score", FILTER_VALIDATE_INT);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    // $date = date("Y-m-d H:i:s");

    $cmd = "INSERT INTO games (Email, score, mode, size, timer, fade) VALUES (?,?,?,?,?,?)";
    $stmt = $dbh->prepare($cmd);
    $args = [$email, $score, $mode, $size, $time, $fade];
    $success = $stmt->execute($args);

    if (!$success) {
        die("Could not insert record into database");
    }

    $cmd = "UPDATE users SET GamesPlayed=GamesPlayed + 1 WHERE Email=?";
    $stmt = $dbh->prepare($cmd);
    $args = [$email];
    $success = $stmt->execute($args);

    if ($success) {
    ?>
        <div id="title">Leaderboard</div>
        <div id="lbcontainer">
            <div class="objcontainer">
                <div class="settingsheader">Your Game History</div>
                <div class="finalsettings">
                    <?php
                    $cmd = "SELECT * FROM games WHERE Email=? ORDER BY date DESC LIMIT 5";
                    $args = [$email];
                    $stmt = $dbh->prepare($cmd);
                    $success = $stmt->execute($args);
                    if (!$success) {
                        echo "No Games Found";
                    } else {
                        while ($row = $stmt->fetch()) {
                            $curScore = $row["score"];
                            $curDate = $row["date"];
                            $curMode = $row["mode"];
                            $curSize = $row["size"];
                            $curTime = $row["timer"];
                            $curFade = $row["fade"];
                            echo "<b>$curScore</b> Score on <i>$curDate</i><br>$curMode, $curSize, $curTime seconds, $curFade Fade<br><br>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="objcontainer">
                <div class="settingsheader">Most Games Played</div>
                <div class="finalsettings">
                    <?php
                    $cmd = "SELECT * FROM users ORDER BY GamesPlayed DESC LIMIT 5";
                    $stmt = $dbh->prepare($cmd);
                    $success = $stmt->execute();
                    if (!$success) {
                        echo "No Users Found";
                    } else {
                        while ($row = $stmt->fetch()) {
                            $curEmail = $row["Email"];
                            $curGames = $row["GamesPlayed"];
                            echo "<b>$curEmail</b> with <b>$curGames</b> games played<br><br>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="objcontainer">
                <div class="settingsheader">Highest Scores</div>
                <div class="finalsettings">
                    <?php
                    $cmd = "SELECT * FROM games ORDER BY score DESC LIMIT 5";
                    $stmt = $dbh->prepare($cmd);
                    $success = $stmt->execute();
                    if (!$success) {
                        echo "No Games Found";
                    } else {
                        while ($row = $stmt->fetch()) {
                            $curScore = $row["score"];
                            $curDate = $row["date"];
                            $curMode = $row["mode"];
                            $curSize = $row["size"];
                            $curTime = $row["timer"];
                            $curFade = $row["fade"];
                            $curEmail = $row["Email"];
                            echo "$curEmail<br><b>$curScore</b> Score on <i>$curDate</i><br>$curMode, $curSize, $curTime seconds, $curFade Fade<br><br>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <form action="play.php" method="post">
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="submit" id="homebutton" class="button" value="Play Again">
        </form>
    <?php
    } else {
        echo "<div id =\"title\">Unable to insert record into database</div>";
    }
    ?>



</body>

</html>