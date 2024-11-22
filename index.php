<?php

require_once __DIR__ . '/config/config.php';

session_start();

require_once('controllers/OeuvresController.php');
// $class = new Controllers\OeuvresController;


// index.php
if (array_key_exists("route", $_GET)) :
    switch ($_GET['route']) {

            // AFFICHE LA PAGE D'ACCUEIL
        case 'oeuvres':
            $controller = new Controllers\OeuvresController;
            $controller->listAllArtworks();
            break;
            // AFFICHE UNE OEUVRE
        case 'oeuvre':
            $controller = new Controllers\OeuvresController;
            $controller->viewArtwork($_GET['id']);
            break;
            // AFFICHE LE FORMULAIRE D'AJOUT D'UNE OEUVRE
        case 'ajouter':
            include 'vues/ajouter.php';
            break;

            // SOUMISSION DU FORMULAIRE DE CREATION D'OEUVRE
        case 'submitFormAddArtwork':
            $controller = new Controllers\OeuvresController;
            $controller->submitFormAddArtwork();
            break;

            // SI LA ROUTE N'EXISTE PAS, REDIRECTION VERS L'ACCUEIL DU SITE 
        default:
            header('location: index.php?route=oeuvres');
            exit;
            break;
    }
else :
    // S'IL N'Y A PAS DE ROUTE REDIRIGE VERS L'ACCUEIL DU SITE 
    header('Location: index.php?route=oeuvres');
    exit;
endif;
