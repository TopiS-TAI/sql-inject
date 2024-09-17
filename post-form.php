<?php
    $errors = ['Annettu allekirjoitus ei ollut validi.'] ;
    $error = $_GET['message'];
?>
<div class="new-post">
    <h4>Uusi posti</h4>
    <form action="send-post.php" method="post">
        <input type="text" name="title" id="title" placeholder="Otsikko"><br>
        <textarea name="body" id="body" placeholder="Viesti" rows="4" cols="64"></textarea><br>
        <textarea name="signature" id="signature" placeholder="Valinnainen allekirjoitus (RSASSA-PKCS1-v1_5, SHA1withRSA)" rows="4" cols="64"></textarea><br>
        <?php if (isset($error)) { ?>
            <p><?php echo $errors[$error]; ?></p>
        <?php } ?>
        <input type="submit" value="Send">
    </form>
</div>