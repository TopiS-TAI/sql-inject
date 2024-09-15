<style>
    li::marker {
        font-size: 1.5em;
    }
    li.sig-ok {
        list-style-type: '✓';
        &::marker {
            color: green;
        }
    }
    li.sig-fail {
        list-style-type: '✗';
        background-color: #FDD;
        &::marker {
            color: red;
        }
    }
    li details {
        font-size:0.9em;
        font-family: sans-serif;
        color: rgba(0,0,0,0.67);
    }
    li details pre {
        max-width: 39em;
        text-wrap: wrap;
        overflow-wrap: break-word;
        background-color: rgba(0, 0, 0, 0.08);
        padding: 0.5em;
    }
    li summary {
        cursor: pointer;
        color: rgba(0,0,0,0.33);
    }
    li input#title {
        font-family: serif;
        font-weight: 600;
        font-size: 1.1em;
        border: 1px solid #DDD;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.5);
    }
    li textarea#body {
        font-family: serif;
        font-size: 1em;
        border: 1px solid #DDD;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.5);
    }
</style>
<ul>
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
                <p><i><?php echo $row['posted'] . ' – ' . htmlspecialchars($author['realname']); ?></i></p>
                <p><?php echo htmlspecialchars($row['body']); ?></p>
                <?php
                    if ($sig_ok != 2) {
                        ?>
                        <details>
                            <summary>Julkinen avain</summary>
                            <pre><?php echo $author['publickey']; ?></pre>
                        </details>
                        <details>
                            <summary>Allekirjoitus</summary>
                            <pre><?php echo $row['signature']; ?></pre>
                        </details>
                    <?php } ?>
        <?php } else { ?>
            <form action="edit-post.php" method="post">
                <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>"><br>
                <p><i><?php echo $row['posted'] . ' – ' . htmlspecialchars($author['realname']); ?></i></p>
                <textarea name="body" id="body"><?php echo $row['body']; ?></textarea><br>
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
            <hr>
        </li>
    <?php } ?>
</ul>