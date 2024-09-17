<header>
    <h1><a href="home.php">Super foorumi</a></h1>
    <details class="user-info">
        <summary>
            Tervettuloa <?php echo $_SESSION['user']['realname']; ?>
        </summary>
        <div class="user-menu">
            <?php if ($_SESSION['user']['role'] == 'admin') { ?>
                <a href="users.php">Käyttäjäinhallinta</a>
            <?php }?>
            <a href="publickey.php">Julkinen avain</a>
            <a href="logout.php">Poistu</a>
        </div>
    </details>
</header>