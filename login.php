<!-- 
Daniel Kogan
March 24th, 2026
PHP file for the intermediary login page.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AimTrainer Login</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div id="title">AimTrainer</div>
    <?php
    include "connect.php";

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($email != NULL && $birthdate != NULL) {
        // Check if user already exists
        $cmd = "SELECT * FROM users WHERE Email=?";
        $stmt = $dbh->prepare($cmd);
        $args = [$email];
        $success = $stmt->execute($args);
        if ($success) {
            $row = $stmt->fetch();
            if ($row == NULL) {
                $createcmd = "INSERT INTO users (Email, Birthdate) VALUES (?, ?)";
                $newstmt = $dbh->prepare($createcmd);
                $newargs = [$email, $birthdate];
                $newsuccess = $newstmt->execute($newargs);
                if ($newsuccess) {
                    echo "<p id =\"message\">Account created, $email!</p>
                    
                    <form action =\"play.php\" method=\"post\">
                        <input name =\"email\" value=\"$email\" style=\"display: none;\">
                        <input type=\"submit\" class =\"button\" value=\"Play Game\">
                    </form>
                    ";
                }
            } else if ($row["Birthdate"] == $birthdate) {

                echo "<p id =\"message\">Welcome back, $email!</p>
                    
                    <form action =\"play.php\" method=\"post\">
                        <input name =\"email\" value=\"$email\" style=\"display: none;\">
                        <input type=\"submit\" class =\"button\" value=\"Play Game\">
                    </form>
                    ";
            } else {
                echo "<p id =\"message\">Incorrect Birthdate.</p>
                    
                    <form action =\"index.php\">
                        <input type=\"submit\" class =\"button\" value=\"Retry Login\">
                    </form>
                    ";
            }
        }
    } else {
        echo "<script>
                window.location.href = 'index.php'
            </script>";
    }
    ?>

</body>

</html>