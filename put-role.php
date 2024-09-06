<?php
    session_start();
    if ($_SESSION['user']['role'] != 'admin') {
        header('Location: home.php');
    }
    if (!isset($_POST['role']) and !isset($_POST['id'])) {
        header('Location: users.php');
    }
    $id = $_POST['id'];
    $role = $_POST['role'];

    include 'connect.php';
    try {
        $sql = 'UPDATE users SET role = :role WHERE users.id = :id;';
        $query = $conn->prepare($sql);
        $query->execute(['role'=>$role, 'id'=>$id]);
    } catch (PDOException $e) {
        var_dump($_POST);
        die('Error: ' . $e->getMessage());
    }
    header('Location: users.php');
?>