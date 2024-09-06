<?php
    try {
        $sql = 'SELECT * FROM users;';
        $query = $conn->prepare($sql);
        $query->execute();
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
    $users = $query->fetchAll();
    $_SESSION['users'] = $users;
?>