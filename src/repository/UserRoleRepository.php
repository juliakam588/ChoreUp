<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Role.php';
require_once __DIR__ . '/../models/Household.php';

class UserRoleRepository extends Repository
{

    public function assignRoleToUser(User $user, Household $household, Role $role) {


        $stmt = $this->database->connect()->prepare('
    INSERT INTO user_roles (user_id, household_id, role_id) VALUES (?, ?, ?)
    ');
        $stmt->execute([
            $user->getId(),
            $household->getHouseholdId(),
            $role->getId()
        ]);

    }

}