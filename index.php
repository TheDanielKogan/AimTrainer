<!-- 
Daniel Kogan
March 24th, 2026
PHP file for the login screen
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AimTrainer</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/logincss.css">
    <script src="js/login.js"></script>
</head>

<body>
    <div id="title">
        AimTrainer
    </div>

    <div id="formcontainer">
        <form action="login.php" method="post">
            <div class="inpcontainer">
                <p>Email</p>
                <input type="email" id ="email" name="email" placeholder="test@example.com" required>
            </div>
            <div class ="inpcontainer">
                <p>Birthdate</p>
                <input type="date" name="birthdate" required>
            </div>
            <p id="errormessage">Invalid</p>
            <input type="submit" class="button" id ="submitbtn">
        </form>
    </div>
</body>

</html>