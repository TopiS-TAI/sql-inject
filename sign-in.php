<?php
    if (
    empty($_POST['username']) or
    empty($_POST['realname']) or
    empty($_POST['password'])
    ) {
        header('Location: sign-in-form.php?error=0');
    } else if (strlen($_POST['password']) < 6) {
        header('Location: sign-in-form.php?error=1');
    } else {
        include 'connect.php';
        $username = $_POST['username'];
        $realname = $_POST['realname'];
        $password = $_POST['password'];

        try {
            $sql = "SELECT * FROM users;";
            $query = $conn->prepare($sql);
            $query->execute();
        } catch (PDOException $e) {
            $sql = NULL;
            $query = NULL;
            die('Error: ' . $e->getMessage());
        }
        $res = $query->fetchAll();
        $found_username = array_column($res, null, 'username')[$username];
        $found_realname = array_column($res, null, 'realname')[$realname];
        if ($found_realname or $found_username) {
            header('Location: sign-in-form.php?error=2');
        } else {
            try {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO users (username, realname, password) VALUES (:username, :realname, :password);";
                $query = $conn->prepare($sql);
                $query->execute(['username'=>$username, 'realname'=>$realname, 'password'=>$hash]);
                header('Location: index.php');
            } catch (PDOException $e) {
                $sql = NULL;
                $query = NULL;
                die('Error: ' . $e->getMessage());
            }
        }

    }
?>