<style>

</style>
<ul class="posts">
    <hr>
    <?php
            include 'connect.php';
            $sql = "SELECT * FROM posts;";
            try {
                $query = $conn->prepare($sql);
                $query->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
            $res = $query->fetchAll();
            foreach($res as $row) {
                $author = array_filter($_SESSION['users'], function($v, $k) use($row) {
                    return $v['id'] === $row['author'];
                }, ARRAY_FILTER_USE_BOTH);
                $author = array_values($author);
                $author = $author[0];
                $sig_messages = array(
                    -1=>'Allekirjoitus virheellinen',
                    0=>'Allekirjoitus ei validi!',
                    1=>'Allekirjoitus OK.',
                    2=>NULL);
                $sig_ok = 2;
                if ($author['publickey'] and $row['signature']) {
                    $sig_binary = base64_decode($row['signature']);
                    $sig_ok = openssl_verify($row['body'], $sig_binary, $author['publickey']);                    
                }
                $sig_message = $sig_messages[$sig_ok];
            ?>
            <li class="<?php echo $sig_ok < 2 ? $sig_ok < 1 ? 'sig-fail' : 'sig-ok' : '';?>" title="<?php echo $sig_message; ?>" >
            <?php
                if (
                    $author['id'] != $_SESSION['user']['id'] and
                    $_SESSION['user']['role'] != 'moderator' and
                    $_SESSION['user']['role'] != 'admin'
                ) {
                ?>
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <div class="post-info"><i><?php echo $row['posted'] . ' – ' . htmlspecialchars($author['realname']); ?></i></div>
                <div class="body"><?php echo htmlspecialchars($row['body']); ?></div>
                <?php
                    if ($sig_ok != 2) {
                        ?>
                        <div class="signature">
                            <details>
                                <summary>Julkinen avain</summary>
                                <pre><?php echo $author['publickey']; ?></pre>
                            </details>
                            <details>
                                <summary>Allekirjoitus</summary>
                                <pre><?php echo $row['signature']; ?></pre>
                            </details>
                        </div>
                    <?php } ?>
        <?php } else { ?>
            <form action="edit-post.php" method="post">
                <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>">
                <div class="post-info"><i><?php echo $row['posted'] . ' – ' . htmlspecialchars($author['realname']); ?></i></div>
                <textarea name="body" id="body"><?php echo $row['body']; ?></textarea>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="author" value="<?php echo $row['author']; ?>">
                <input type="submit" value="Päivitä">
            </form>
            <?php } ?>
            <?php
                if ($_SESSION['user']['role'] == 'admin') {
                    ?>
                    <form action="delete-post.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit" value="Poista">
                    </form>
            <?php } ?>
        </li>
    <?php } ?>
</ul>