<?php
session_start();
if ($_SESSION['user']['role'] != 'admin' or empty($_POST['id'])) {
    header('Location: home.php');
} else {
    include 'connect.php';
    $id = $_POST['id'];
    try {
        $sql = "DELETE FROM posts WHERE id = ?;";
        $query = $conn->prepare($sql);
        $query->execute(array($id));
        header('Location: home.php');
    } catch (PDOException $e) {
        die('Error: ' . $e.getMessage());
    }

}
?>