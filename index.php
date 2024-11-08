<?php include('header.php');
include('oeuvres.php');
?>
<div id="liste-oeuvres">
    <?php foreach ($oeuvres as $oeuvre) { ?>
        <article class="oeuvre">
            <!-- utilisation de la fonction htmlspecialchars pour éviter les failles xss  -->
            <a href="oeuvre.php?id=<?= htmlspecialchars($oeuvre['id']); ?>">
                <img src="<?= htmlspecialchars($oeuvre['image']); ?>" alt="<?= htmlspecialchars($oeuvre['artiste']); ?>">
                <h2><?= htmlspecialchars($oeuvre['titre']); ?></h2>
                <p class="description"><?= htmlspecialchars($oeuvre['description']); ?></p>
            </a>
        </article>
    <?php } ?>
</div>

<?php include('footer.php'); ?>