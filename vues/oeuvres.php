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
                    <img src="img/<?= htmlspecialchars($oeuvre['image']); ?>" alt="<?= htmlspecialchars($oeuvre['titre']); ?>">
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