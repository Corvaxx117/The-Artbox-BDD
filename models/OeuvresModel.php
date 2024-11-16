<?php

namespace Models;

class OeuvresModel extends Database
{
    // RECHERCHE UNE OEUVRE PAR SON TITRE
    public function getOneArtwork(string $titre)
    {
        $req = "SELECT * FROM oeuvres WHERE titre = ?";
        return $this->findOne($req, [$titre]);
    }
    // AJOUTE UNE NOUVELLE OEUVRE
    public function addNewArtwork(array $data): void
    {
        $this->addOne(
            'oeuvres',
            'titre, auteur, image, description',
            '?,?,?,?',
            $data
        );
    }
}
