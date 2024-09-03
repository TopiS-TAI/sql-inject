<?php
    if (empty($_POST['username']) or empty($_POST['realname']) or empty($_POST['password'])) {
        header('Location: sign-in-form.php');
    } else {
        include 'connect.php';
        $username = $_POST['username'];
        $realname = $_POST['realname'];
        $password = $_POST['password'];
        try {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (username, realname, password) VALUES (:username, :realname, :password);";
            $query = $conn->prepare($sql);
            $query->execute(['username'=>$username, 'realname'=>$realname, 'password'=>$hash]);
            header('Location: index.php');
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
?>