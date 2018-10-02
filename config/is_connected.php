<?php
if (isset($_SESSION['username']) && $_SESSION['username'] != null)
    header('Location: connexion.php?error=1');

?>
<?php if (isset($_GET['status'])) { ?>

        <div style="padding:5px;border:1px solid blue;color: blue !important;font-weight: bold;text-align:center;width:100%;margin:10px;">

            <?php if ($_GET['status'] == "1") { ?>
                Vous vous êtes correctement déconnecté.
            <?php }} ?>