<?php

namespace Models;

require_once('Database.php');

class OeuvresModel extends Database
{
    // RECHERCHE UNE OEUVRE PAR SON ID
    public function getOneArtworkById(int $id)
    {
        $req = "SELECT * FROM oeuvres WHERE id = ?";
        return $this->findOne($req, [$id]);
    }
    // RECUPERATION DE TOUTES LES OEUVRES
    public function getAllArtworks(): array
    {
        $req = "SELECT * FROM oeuvres";
        return $this->findAll($req);
    }
    // AJOUTE UNE NOUVELLE OEUVRE
    public function addNewArtwork(array $data): void
    {
        $this->addOne(
            'oeuvres',
            'titre, artiste, image, description',
            '?,?,?,?',
            $data
        );
    }
}
