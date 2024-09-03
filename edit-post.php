<?php
session_start();
    if (
    empty($_POST['id']) or
    empty($_POST['title']) or
    empty($_POST['body']) or (
    $_SESSION['user']['id'] != $_POST['author'] and (
    $_SESSION['user']['role'] != 'moderator' and
    $_SESSION['user']['role'] != 'admin'))
    ) {
        // header('Location: home.php');
        var_dump(empty($_POST['id']));
        var_dump(empty($_POST['title']));
        var_dump(empty($_POST['body']));
        var_dump($_SESSION['user']['id'] != $_POST['author']);
        var_dump($_SESSION['user']['role'] != 'moderator');
        var_dump($_SESSION['user']['role'] != 'admin');
    } else {
        include 'connect.php';
        $title = $_POST['title'];
        $body = $_POST['body'];
        $id = $_POST['id'];

        try {
            $sql = "UPDATE posts
                SET title = :title, body = :body
                WHERE id = :id;";
            $query = $conn->prepare($sql);
            $query->execute(['title'=>$title, 'body'=>$body, 'id'=>$id]);
            header('Location: home.php');
        } catch (PDOException $e) {
            die("Error: " . $e.getMessage());
        }
    }
?>