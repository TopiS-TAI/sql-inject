<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }
    $key = $_SESSION['user']['publickey'];
    $error = $_GET['error'];
    $message = NULL;
    $messages = [
        'Annettu avain ei ole validi.',
        'Tietokantavirhe.'
    ];
    if (isset($error)) {
        $message = $messages[$error];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public key</title>
</head>
<body>
    <h1>Lisää tai päivitä julkinen avain</h1>
    <form action="add-key.php" method="post">
        <?php if (isset($message)) { echo '<p>' . $message . '</p>'; } ?>
        <textarea name="key" id="key" rows="10" cols="64" placeholder="Julkinen RSA-avain" required><?php echo $key; ?></textarea>
        <input type="submit" value="Lähetä">
    </form>
</body>
</html>