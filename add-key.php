<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }

    $key = $_POST['key'];
    try {
        include 'connect.php';
        $details = openssl_pkey_get_details(openssl_get_publickey($key));
        $sql = 'UPDATE users SET publickey=:publickey WHERE id=:id;';
        try {
            $query = $conn->prepare($sql);
            $query->execute(['publickey'=>$key, 'id'=>$_SESSION['user']['id']]);
        } catch (PDOException $e) {
            header('Location: publickey.php?error=1');
        }
        header('Location: home.php');
    } catch (Error $e) {
        header('Location: publickey.php?error=0');
    }
?>