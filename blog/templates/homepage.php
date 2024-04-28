<?php $title = "Le blog de samuel"; ?>
<?php

phpinfo();

?>
<?php ob_start(); ?>
<h1>Le super blog de samuel !</h1>
<p>Derniers billets du blog :</p>

<?php
foreach ($posts as $post) {
?>
    <div class="news">
        <h3>
            <?= $post->title; ?>
            <em>le <?= $post->frenchCreationDate; ?></em>
        </h3>
        <p>
            <?= nl2br($post->content); ?>
            <br />
            <em><a href="index.php?action=post&id=<?= urlencode($post->identifier) ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
