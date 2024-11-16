<?php

namespace Controllers;

use Models\OeuvresModel;


class OeuvresController extends BaseController

{
    protected $oeuvresModel;

    public function __construct()
    {
        $this->oeuvresModel = new OeuvresModel();
    }

    // VERIFICATION DES DONNEES ENVOYEES PAR L'UTILISATEUR
    public function formAddArtworkValidator(array &$errors)
    {
        // Si tous les champs sont rempli :
        if (
            array_key_exists('titre', $_POST) &&
            array_key_exists('auteur', $_POST) &&
            array_key_exists('image', $_POST) &&
            array_key_exists('description', $_POST)
        ) {
            // Verification des champs
            // Titre
            if (strlen($_POST['titre']) < 2 || strlen($_POST['titre']) > 150)
                $errors[] = "Le champ prénom doit contenir entre 2 et 150 caractères";
            // Auteur
            if (strlen($_POST['auteur']) < 2 || strlen($_POST['auteur']) > 150)
                $errors[] = "Le champ nom doit contenir entre 2 et 25 caractères";
            // Image
            if (strlen($_POST['image']) < 2 || strlen($_POST['image']) > 200)
                $errors[] = "Le champ nom doit contenir entre 2 et 25 caractères";
            // Description
            if (strlen($_POST['description']) < 2 || strlen($_POST['description']) > 650)
                $errors[] = "Le champ nom doit contenir entre 2 et 650 caractères";
        }
    }

    // SOUMISSION DES DONNEES POUR AJOUT D'UNE OEUVRE'
    public function submitFormAddArtwork()
    {
        $errors = [];
        $valids = [];

        // Vérifier si le formulaire est soumis correctement
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Valider les données du formulaire
            $this->formAddArtworkValidator($errors);

            if (count($errors) == 0) {

                // Vérifier si l'oeuvre n'existe pas déjà dans la bdd pour éviter les doublons
                $oeuvreExist = $this->oeuvresModel->getOneArtwork($_POST['titre']);

                if (!empty($oeuvreExist)) {
                    $errors[] = 'Cette oeuvre existe déjà !';
                    // Stocker les données dans la session temporaire pour pré-remplir le formulaire
                    $_SESSION['temp_data'] = $_POST;
                } else {
                    // SI PAS D'ERREUR :
                    $data = [
                        trim($_POST['titre']),
                        trim($_POST['auteur']),
                        trim($_POST['image']),
                        trim($_POST['description']),

                    ];
                    // Ajout des données du nouvel utilisateur dans la bdd
                    $this->oeuvresModel->addNewArtwork($data);
                    $valids[] = 'Votre demande d\'ajout a bien été enregistrée.';
                }
            } else {
                // Si des erreurs sont présentes, stocker les données dans la session temporaire
                $_SESSION['temp_data'] = $_POST;
            }
        }
    }
}
