<?php include('header.php'); ?>

<div class="errorContainer">
    <?php require_once 'errors.php'; ?>
    <?php require_once 'valids.php'; ?>
</div>

<article id="detail-oeuvre">
    <div id="img-oeuvre">
        <img src="<?= IMAGE_BASE_URL . htmlspecialchars($oeuvre['image']); ?>" alt="une image du tableau <?php echo htmlspecialchars($oeuvre['titre']); ?>">
    </div>
    <div id="contenu-oeuvre">
        <h1><?php echo htmlspecialchars($oeuvre['titre']); ?></h1>
        <p class="description"><?php echo htmlspecialchars($oeuvre['artiste']); ?></p>
        <p class="description-complete">
            <?php echo htmlspecialchars($oeuvre['description']); ?>
        </p>
    </div>
</article>

<?php include('footer.php'); ?>