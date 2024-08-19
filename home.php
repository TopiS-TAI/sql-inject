<?php
    session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super foorumi</title>
</head>
<body>
    <h1>Super foorumi</h1>
    <p>Tervettuloa <?php echo $_SESSION['user']['realname'] ?></p>
    <?php
    include 'posts.php';
    include 'post-form.php';
    ?>
</body>
</html>