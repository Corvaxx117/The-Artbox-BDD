<?php include('header.php'); ?>
<div class="errorContainer">
    <?php require_once 'errors.php'; ?>
    <?php require_once 'valids.php'; ?>
</div>

<h1>Liste des Œuvres</h1>
<div id="liste-oeuvres">
    <?php if (!empty($oeuvres)) : ?>
        <?php foreach ($oeuvres as $oeuvre) : ?>
            <article class="oeuvre">
                <a href="index.php?route=oeuvre&id=<?= htmlspecialchars($oeuvre['id']); ?>">
                    <?php
                    // Vérifier si l'image est une URL ou un chemin relatif local
                    $imageSrc = filter_var($oeuvre['image'], FILTER_VALIDATE_URL) ?
                        htmlspecialchars($oeuvre['image']) :
                        IMAGE_BASE_URL . htmlspecialchars($oeuvre['image']);
                    ?>
                    <img src="<?= $imageSrc; ?>" alt="<?= htmlspecialchars($oeuvre['titre']); ?>">
                    <h2><?= htmlspecialchars($oeuvre['titre']); ?></h2>
                    <p class="description"><?= htmlspecialchars($oeuvre['description']); ?></p>
                </a>
            </article>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Aucune œuvre n'a été trouvée.</p>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>