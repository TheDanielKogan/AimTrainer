<!-- 
Daniel Kogan
March 24th, 2026
PHP file to connect to database
-->

<?php
try {
    $dbh = new PDO("mysql:host=localhost;dbname=kogand4_db", "root", "");
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}