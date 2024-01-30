<?php
require_once 'Repository.php';
require_once __DIR__ . '/../models/Chore.php';


class ChoreRepository extends Repository
{

    public function getAllChores()
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM chores');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChore($choreId) {
        $stmt = $this->database->connect()->prepare('SELECT * FROM chores WHERE id = :choreId');
        $stmt->bindParam(':choreId', $choreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}