<?php include('header.php'); ?>

<div class="errorContainer">
    <?php require_once 'errors.php'; ?>
    <?php require_once 'valids.php'; ?>
</div>

<article id="detail-oeuvre">
    <div id="img-oeuvre">
        <?php
        // Vérifier si l'image est une URL ou un chemin relatif local
        $imageSrc = filter_var($oeuvre['image'], FILTER_VALIDATE_URL) ?
            htmlspecialchars($oeuvre['image']) :
            IMAGE_BASE_URL . htmlspecialchars($oeuvre['image']);
        ?>
        <img src="<?= $imageSrc; ?>" alt="Une image du tableau <?= htmlspecialchars($oeuvre['titre']); ?>">
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