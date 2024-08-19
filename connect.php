<?php
    $host="localhost";
    $dbuser="next-admin";
    $dbpassword="next-admin";
    $db="next-admin";

    try {
        $conn = new PDO("mysql:host=$host; dbname=$db", $dbuser, $dbpassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOExceptio $e) {
        die("Virhe: " . $e->getMessage());
    }
?>