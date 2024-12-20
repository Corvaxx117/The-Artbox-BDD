<?php

namespace Models;

require('config/config.php');
require('exception/DuplicateEntryException.php');

use exception\DuplicateEntryException;


abstract class Database
{
    protected $bdd;

    public function __construct()
    {
        // PARAMETRE DE CONNEXION A LA BDD
        $this->bdd = new \PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS,
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // retourne un tableau indexé par le nom de la colonne
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // lance PDOExeptions
            ]
        );
    }
    // RECUPERATION DE TOUS LES ELEMENTS D'UNE TABLE
    protected function findAll(string $req, array $params = []): array
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }
    // RECUPERATION D'UN ELEMENT 
    protected function findOne($req, $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }
    // AJOUT D'UN ELEMENT
    protected function addOne(string $table, string $columns, string $values, $data)
    {
        try {
            $query = $this->bdd->prepare('INSERT INTO ' . $table . ' (' . $columns . ') VALUES (' . $values . ')');
            $query->execute($data);
            return $this->bdd->lastInsertId();
        } catch (\PDOException $e) {
            // Vérifier si l'erreur provient d'une violation de contrainte UNIQUE
            if ($e->getCode() === '23000') { // Code d'erreur SQL pour contrainte UNIQUE
                throw new DuplicateEntryException('Duplication détectée : l’entrée existe déjà dans la base de données.');
            } else {
                throw $e; // Réexécute les autres erreurs non liées à la duplication
            }
        }
    }
}
