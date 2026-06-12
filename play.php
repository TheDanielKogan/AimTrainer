<!-- 
Daniel Kogan
March 24th, 2026
PHP file for the game, changed to make sure email is provided
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AimTrainer</title>
    <script src="js/index.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    if ($email == NULL) {
        echo "<div id=\"title\">Email Not Provided</div>";
    } else {
    ?>
    
    <canvas id="splashpage" width="400" height="400"></canvas>

    <div id="startpage">
        <div id="title">
            AimTrainer
        </div>
        <div id="settings">
            <div id="modes" class="selectorcontainer">
                <p class="settingsheader">Modes</p>
                <input id="multi" type="radio" name="mode" value="Multi" checked>
                <label class="selector" for="multi">Multiple Targets</label>

                <input id="single" type="radio" name="mode" value="Single">
                <label class="selector" for="single">Single Target</label>
            </div>
            <div id="sizes" class="selectorcontainer">
                <p class="settingsheader">Sizes</p>
                <input id="s" type="radio" name="size" value="Small" checked>
                <label class="selector" for="s">Small</label>

                <input id="m" type="radio" name="size" value="Medium">
                <label class="selector" for="m">Medium</label>

                <input id="l" type="radio" name="size" value="Large">
                <label class="selector" for="l">Large</label>
            </div>
            <div id="timers" class="selectorcontainer">
                <p class="settingsheader">Timer</p>
                <input id="60s" type="radio" name="time" value="60" checked>
                <label class="selector" for="60s">60 Seconds</label>

                <input id="30s" type="radio" name="time" value="30">
                <label class="selector" for="30s">30 Seconds</label>

                <input id="15s" type="radio" name="time" value="15">
                <label class="selector" for="15s">15 Seconds</label>

                <input id="10s" type="radio" name="time" value="10">
                <label class="selector" for="10s">10 Seconds</label>
            </div>
            <div id="fade" class="selectorcontainer">
                <p class="settingsheader">Fadeaway</p>
                <input id="fadeno" type="radio" name="fade" value="No" checked>
                <label class="selector" for="fadeno">No</label>

                <input id="fadeyes" type="radio" name="fade" value="Yes">
                <label class="selector" for="fadeyes">Yes</label>
            </div>
            <!-- <div id="pbs">
                <p class="settingsheader">Game History</p>
                <div id="gamehistory">

                </div>
            </div> -->
        </div>
        <div id="helpinfo">
            <p>Simply select the settings you wish to play on this page and click start<br> then try to click as many
                targets as you can before the time runs out!</p>
        </div>
        <div id="bottombtns">
            <button id="helpbutton" class="button">Help</button>
            <button id="startbutton" class="button">Start Game</button>
        </div>
    </div>
    <div id="gamewindow">
        <div id="header">
            <div class="scorecontainer">
                <p id="score">Score: 0</p>
                <img src="images/target.png" width="30px" height="30px" id="targetIcon">
            </div>
            <div id="timeleft">
                <label for="timerProgress" id="timerLabel">Time Left: </label>
                <progress id="timerProgress" value="0" max="60" width="60"></progress>
            </div>
        </div>
        <div id="gamepage"></div>
    </div>
    <div id="gameoverwindow">
        <div id="finalscorecontainer">
            <p id="finalscore">Final Score: 0</p>
            <img src="images/target.png" width="50px" height="50px" id="finaltargeticon">
        </div>

        <div>
            <p class="settingsheader">Settings for This Game</p>
            <p id="finalmode" class="finalsettings">Mode: </p>
            <p id="finalsize" class="finalsettings">Size: </p>
            <p id="finaltime" class="finalsettings">Timer: </p>
            <p id="finalfade" class="finalsettings">Fadeaway: </p>
        </div>

        <p class="settingsheader">Best Score for These Settings</p>
        <p class="finalsettings" id="pb">Score: No Previous Score</p>
        <br>
        <br>
        <form action="leaderboard.php" method="post">
            <input type="hidden" name="mode" id="modeform">
            <input type="hidden" name="size" id="sizeform">
            <input type="hidden" name="time" id="timeform">
            <input type="hidden" name="fade" id="fadeform">
            <input type="hidden" name="score" id="scoreform">
            <input type="hidden" name="email" value="<?=$email?>">
            <input type ="submit" class="button" value ="Leaderboard">
        </form>
        <button id="homebutton" class="button" style="display:none">Play Again</button>
    </div>
    <?php
    }
    ?>
</body>

</html>