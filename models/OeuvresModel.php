<?php

namespace Models;

class OeuvresModel extends Database
{
    // RECHERCHE UNE OEUVRE PAR SON ID
    public function getOneArtwork(int $id)
    {
        $req = "SELECT * FROM oeuvres WHERE id = ?";
        return $this->findOne($req, [$id]);
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
