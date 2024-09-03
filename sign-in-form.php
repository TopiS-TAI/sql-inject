<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
</head>
<body>
    <h1>Kirjaudu käyttäjäksi</h1>
    <form action="sign-in.php" method="post">
        <label for="username">Käyttäjänimi</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="realname">Oikea nimi</label>
        <input type="text" name="realname" id="realname" required>
        <br>
        <label for="password">Salasana</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Lähetä">
        <button onclick="history.back()">Peruuta</button>
    </form>

</body>
</html>