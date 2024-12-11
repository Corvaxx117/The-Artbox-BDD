<?php

namespace Controllers;

require_once __DIR__ . '/../models/OeuvresModel.php';
require('exception/DuplicateEntryException.php');

use exception\DuplicateEntryException;
use Models\OeuvresModel;


class OeuvresController
{
    protected $oeuvresModel;

    public function __construct()
    {
        $this->oeuvresModel = new OeuvresModel();
    }
    // AFFICHE TOUTES LES OEUVRES
    public function listAllArtworks()
    {
        $oeuvres = $this->oeuvresModel->getAllArtworks();
        include 'vues/oeuvres.php';
    }
    //AFFICHE UNE OEUVRE
    public function viewArtwork($id)
    {
        $error = [];
        // Vérifiez si un ID valide est fourni
        if (!$id || !is_numeric($id)) {
            $error[] =  'l\'id de l\'oeuvre n\'est pas valide.';
            $_SESSION['errors'] = $error;
            header('Location: index.php?page=oeuvres');
            exit();
        }

        // Récupérer l'œuvre correspondante depuis le modèle
        $oeuvre = $this->oeuvresModel->getOneArtworkbyId($id);

        // Si l'œuvre n'existe pas, redirigez vers la liste des œuvres
        if (!$oeuvre) {
            $error[] =  'l\'oeuvre n\'existe pas.';
            $_SESSION['errors'] = $error;
            header('Location: index.php?page=oeuvres');
            exit();
        }

        // Inclure la vue et transmettre les données
        include 'vues/oeuvre.php';
    }
    // VERIFICATION DES DONNEES ENVOYEES PAR L'UTILISATEUR
    public function formAddArtworkValidator(array &$errors)
    {
        // Si tous les champs sont rempli :
        if (
            array_key_exists('titre', $_POST) &&
            array_key_exists('artiste', $_POST) &&
            array_key_exists('image', $_POST) &&
            array_key_exists('description', $_POST)
        ) {
            // Verification des champs
            // Titre

            // Verifier le titre avec une regexp pour eviter les caractères spéciaux
            if (strlen($_POST['titre']) < 2 || strlen($_POST['titre']) > 200)
                $errors[] = "Le champ prénom doit contenir entre 2 et 200 caractères";
            // Auteur
            if (strlen($_POST['artiste']) < 2 || strlen($_POST['artiste']) > 200)
                $errors[] = "Le champ nom doit contenir entre 2 et 200 caractères";
            // Image (URL uniquement)
            if (!empty($_POST['image'])) {
                $imageUrl = trim($_POST['image']);

                // Vérifier que l'entrée est une URL valide
                if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    $errors[] = "L'URL de l'image n'est pas valide.";
                } else {
                    // Vérifier si l'URL retourne un type MIME valide
                    $headers = @get_headers($imageUrl, 1);
                    $contentType = $headers['Content-Type'] ?? null;

                    // Vérifier que le type MIME commence par "image/"
                    if (!$contentType || strpos($contentType, 'image/') !== 0) {
                        $errors[] = "L'URL ne pointe pas vers une image valide.";
                    }
                }
            } else {
                // Si aucune image n'est fournie
                $errors[] = "Une image doit être fournie via une URL valide.";
            }
            // Filegetcontents -> creer une ressource e charge en memoire le contenu de l'url
            // getMimeType -> renvoie le type mime de la ressource
            // mime_content_type -> renvoie le type mime de la ressource(pour les fichiers uploadés) -> meilleur moyen pour connaitre le type d'un fichier 
            // utiliser le chemin relatif pour les images 

            // Description
            if (strlen($_POST['description']) < 2 || strlen($_POST['description']) > 650)
                $errors[] = "Le champ nom doit contenir entre 2 et 650 caractères";
        } else {
            // Si des champs manquent dans $_POST
            $errors[] = "Tous les champs du formulaire doivent être remplis.";
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

            if (count($errors) === 0) {
                $data = [
                    trim($_POST['titre']),
                    trim($_POST['artiste']),
                    trim($_POST['image']),
                    trim($_POST['description']),
                ];

                try {
                    // Tentative d'ajout dans la base de données
                    $this->oeuvresModel->addNewArtwork($data);

                    // Si réussi, stocker un message de succès
                    $valids[] = 'L\'œuvre a été ajoutée avec succès.';
                    $_SESSION['valids'] = $valids;
                    unset($_SESSION['temp_data']);

                    // Redirection vers la liste des œuvres
                    header('Location: index.php?route=oeuvres');
                    exit();
                } catch (DuplicateEntryException $e) {
                    $errors[] = 'Une œuvre avec ce titre existe déjà !';
                } catch (\Exception $e) {
                    // Gérer les exceptions (doublons ou autres erreurs)
                    $errors[] = 'Une erreur est survenue lors de l\'ajout de l\'œuvre. Veuillez réessayer.';
                }
            }

            // Si des erreurs sont présentes, stocker les données et les erreurs dans la session
            $_SESSION['errors'] = $errors;
            $_SESSION['temp_data'] = $_POST;

            // Redirection vers le formulaire
            header('Location: index.php?route=ajouter');
            exit();
        }
    }
}
