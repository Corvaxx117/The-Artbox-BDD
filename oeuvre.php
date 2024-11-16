<?php
include('vues/header.php');

// Récupération de l'id dans les paramètres de l'url
$id = $_GET['id'];
$o = null;

include('oeuvres.php');

// Obtenir le nombre total d'œuvres dans le tableau
$nombreOeuvres = count($oeuvres);

// ********** CODE PERSONNEL ***************

// Si l'ID dans l'url est supérieur au nombre total d'œuvres, rediriger vers l'accueil
// !!! a eviter si l'on a a faire a des valeurs numeriques 
// if ($id > $nombreOeuvres || $id < 1) {
//     header('location: index.php');
//     exit();
// }

// Parcours du tableau dans oeuvres.php
// foreach ($oeuvres as $oeuvre) {
//     // Si l'id présent dans l'url correspond à l'id de l'oeuvre dans le tableau
//     if ($id == $oeuvre['id']) {
//         $o = $oeuvre;
//         break;
//     }
// }

// ********** CORRECTION *************

// On teste si la valeur de $id existe dans les clés du tableau oeuvres
// Si oui on affecte a $o l'oeuvre ciblée
// Sinon on l'affecte a null
// On peut tester plusieurs variables avec cet opérateur (??) sur une meme ligne 
// exemple : 
/*<?php

// $foo = null;
// $bar = null;
// $baz = 1;
// $qux = 2;

// echo $foo ?? $bar ?? $baz ?? $qux; // outputs 1 */

$o = $oeuvres[$id] ?? null;

// tant que $o est empty (null, int 0, false, '0') On rentre dans la condition 
// if ($o == false,ou $o === null)
if (!$o) {
    header('location: index.php');
    exit();
}

?>
<article id="detail-oeuvre">
    <div id="img-oeuvre">
        <img src="<?php echo htmlspecialchars($o['image']); ?>" alt="<?php echo htmlspecialchars($o['titre']); ?>">
    </div>
    <div id="contenu-oeuvre">
        <h1><?php echo htmlspecialchars($o['titre']); ?></h1>
        <p class="description"><?php echo htmlspecialchars($o['artiste']); ?></p>
        <p class="description-complete">
            <?php echo htmlspecialchars($o['description']); ?>
        </p>
    </div>
</article>

<?php include('vues/footer.php'); ?>