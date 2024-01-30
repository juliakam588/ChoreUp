<?php

require_once __DIR__ . '/../models/Role.php';
require_once 'Repository.php';

class RoleRepository extends Repository
{
    public function getRoleByName($name) {
        $stmt = $this->database->connect()->prepare('SELECT * FROM roles WHERE name = :name');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $roleData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($roleData) {
            $role = new Role($roleData['name']);
            $role->setId($roleData['id']);
            return $role;
        }
        return null;
    }


}