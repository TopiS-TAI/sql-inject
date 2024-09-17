<?php
    session_start();
    if(!array_key_exists('user', $_SESSION)) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super foorumi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    include 'header.php';
    ?>
    <main>
        <h1>Keskustelu</h1>
    <?php
    include 'posts.php';
    include 'post-form.php';
    ?>
    </main>
</body>
</html>