<?php
    session_start();
    if ($_SESSION['user']['role'] != 'admin') {
        header('Location: home.php');
    }
    include 'connect.php';
    include 'get-users.php';
    $users = $_SESSION['users'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Käyttäjät</title>
</head>
<body> 
    <h1>Käyttäjät</h1>
    <a href="home.php">Postit</a>
    <table>
        <thead>
            <tr>
                <th>Käyttäjänimi</th>
                <th>Oikea nimi</th>
                <th>Rooli</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($users as $user) { ?>
                    <tr>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['realname']; ?></td>
                        <td>
                            <form action="put-role.php" method="post">
                                <select onchange="this.form.submit()" name="role" id="role" value="<?php echo $user['role'] ?>">
                                    <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>Käyttäjä</option>
                                    <option value="moderator" <?php echo $user['role'] == 'moderator' ? 'selected' : ''; ?>>Moderaattori</option>
                                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Pääkäyttäjä</option>
                                </select>
                                <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                            </form>
                            
                        </td>
                    </tr>
                <?php }
            ?>
        </tbody>
    </table>
    
</body>
</html>