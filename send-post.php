<?php
include 'connect.php';
session_start();
$title = $_POST['title'];
$body = $_POST['body'];
$signature = $_POST['signature'];

$userId = $_SESSION['user']['id'];
$publicKey = $_SESSION['user']['publickey'];

$today = date("Y-m-d");

$sig_binary = base64_decode($signature);
if (isset($publicKey) and openssl_verify($body, $sig_binary, $publicKey)) {
    $sql = "INSERT INTO posts (title, body, posted, author, signature) VALUES (:title, :body, :posted, :userId, :signature);";
    
    try {
        $query = $conn->prepare($sql);
        $query->execute(['title'=>$title, 'body'=>$body, 'posted'=>$today, 'userId'=>$userId, 'signature'=>$signature]);
        header('Location: home.php');
    } catch (PDOException $e) {
        die('Virhe: ' . $e->getMessage());
    }
} else {
    header('Location: home.php?message=0');
}



?>