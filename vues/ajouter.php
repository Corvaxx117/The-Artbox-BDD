<?php require 'header.php'; ?>
<div class="errorContainer">
    <?php require_once 'errors.php'; ?>
    <?php require_once 'valids.php'; ?>
</div>

<form action="index.php?route=submitFormAddArtwork" method="POST">
    <div class="champ-formulaire">
        <label for="titre">Titre de l'œuvre</label>
        <input type="text" name="titre" id="titre" required value="<?= isset($_SESSION['temp_data']['titre']) ? htmlspecialchars($_SESSION['temp_data']['titre']) : '' ?>">
    </div>
    <div class="champ-formulaire">
        <label for="artiste">Auteur de l'œuvre</label>
        <input type="text" name="artiste" id="artiste" required value="<?= isset($_SESSION['temp_data']['artiste']) ? htmlspecialchars($_SESSION['temp_data']['artiste']) : '' ?>">
    </div>
    <div class="champ-formulaire">
        <label for="image">URL de l'image </label>
        <input type="text"
            name="image"
            id="image"
            required value="<?= isset($_SESSION['temp_data']['image']) ? htmlspecialchars($_SESSION['temp_data']['image']) : '' ?>"
            accept=".jpeg, .jpg, .png, .heic, .gif, .webp">
    </div>
    <small>Extensions autorisées : JPEG, JPG, PNG, HEIC, WEBP</small>

    <div class="champ-formulaire">
        <label for="description">Description</label>
        <textarea name="description" id="description" required value="<?= isset($_SESSION['temp_data']['description']) ? htmlspecialchars($_SESSION['temp_data']['description']) : '' ?>" required value="<?= isset($_SESSION['temp_data']['image']) ? htmlspecialchars($_SESSION['temp_data']['image']) : '' ?>"></textarea>
    </div>
    <!-- <input type="hidden" value="<?= $_SESSION['shield'] ?>" name="shield"> -->
    <input type="submit" value="Valider" name="submit">
</form>

<?php require 'footer.php'; ?>