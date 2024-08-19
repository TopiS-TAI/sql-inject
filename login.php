<?php

include 'connect.php';
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users;";
try {
    $query = $conn->prepare($sql);
    $query->execute();
}
catch (PDOException $e) {
    $conn = null;
    $query = null;
    die("Virhe: " . $e->getMessage());
}
$res = $query->fetchAll();
$conn = null;
$query = null;
if (count($res)) {
    $found = array_search(array('username' => $username, 'password' => $password), $res);
    session_start();
    $_SESSION['user'] = $res[$found];
    $_SESSION['users'] = $res;
    header('Location: home.php');
    exit;
} else {
    header('Location: error.php');
exit;
}
echo count($res);
?>