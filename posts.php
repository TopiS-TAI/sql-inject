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
            ?>
            <li>
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
                <p>User<?php echo $_SESSION['user']['id'] ?></p>
                <p>Author<?php echo $author['id'] ?></p>

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