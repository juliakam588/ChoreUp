<?php
require_once 'Repository.php';
require_once __DIR__ . '/../models/Household.php';

class HouseholdRepository extends Repository
{
    public function createHouseholdWithDefaultChores($code): Household
    {

        $stmt = $this->database->connect()->prepare('INSERT INTO households (code) VALUES (:code) RETURNING id');
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        $household = $stmt->fetch(PDO::FETCH_ASSOC);
        $householdId = $household['id'];


        $stmt = $this->database->connect()->prepare('SELECT * FROM chores');
        $stmt->execute();
        $chores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($chores as $chore) {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO chore_settings (chore_id, times_in_a_week, duration, household_id) 
                VALUES (:choreId, 1, 15, :householdId)
            ');
            $stmt->bindParam(':choreId', $chore['id'], PDO::PARAM_INT);
            $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
            $stmt->execute();
        }

        return new Household($householdId, $code);
    }


    public function getHouseholdByCode($code): ?Household
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM households WHERE code = :code
    ');
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();

        $household = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$household) {
            return null;
        }

        return new Household($household['id'], $household['code']);
    }

    public function getHousehold($householdId): Household
    {
        $stmt = $this->database->connect()->prepare('
        SELECT h.code as code, u.id as user_id, u.email, ud.name as user_name, ud.photo as user_photo, r.name as role_name
        FROM users u
        INNER JOIN user_household uh ON u.id = uh."userID"
        INNER JOIN user_roles ur ON u.id = ur.user_id
        INNER JOIN roles r ON ur.role_id = r.id
        INNER JOIN households h ON uh."householdID" = h.id
        LEFT JOIN users_details ud ON u.id_user_details = ud.id
        WHERE uh."householdID" = :householdId
    ');

        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();

        $householdData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        $householdCode = '';

        foreach ($householdData as $index => $userData) {
            if ($index === 0) { // Assuming that the household code is the same for all users, fetch it from the first one
                $householdCode = $userData['code'];
            }
            $role = new Role($userData['role_name']);
            $user = new User(
                $userData['user_id'],
                $userData['email'],
                null,
                $userData['user_name'],
                $userData['user_photo'],
                $role
            );
            $users[] = $user;
        }

        $household = new Household($householdId, $householdCode);
        $household->setUsers($users);
        return $household;
    }

    public function getHouseholdCodeByHouseholdId($householdId)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT code FROM households WHERE id = :householdId
    ');
        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['code'];
    }

    public function generateHouseholdCode()
    {
        return substr(md5(uniqid(mt_rand(), true)), 0, 8);
    }

    public function addUserToHousehold(User $user, Household $household)
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO user_household ("userID", "householdID") VALUES (?, ?)
    ');

        $stmt->execute([
            $user->getId(),
            $household->getHouseholdId()
        ]);
    }

    public function getUserHouseholdId($userId)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT "householdID" FROM user_household WHERE "userID" = :userId
        ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['householdID'] : null;
    }

    public function getHouseholdMembers($householdId)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.id, u.email, ud.name, ud.photo, r.name as role_name, (r.name = \'Household Admin\') as is_admin
            FROM users u
            INNER JOIN user_household uh ON u.id = uh."userID"
            INNER JOIN user_roles ur ON u.id = ur.user_id
            INNER JOIN roles r ON ur.role_id = r.id
            LEFT JOIN users_details ud ON u.id_user_details = ud.id
            WHERE uh."householdID" = :householdId
        ');


        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChoreSettingsForHousehold($householdId): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT cs.id, cs.chore_id, cs.times_in_a_week, cs.duration, cs.household_id, c.name 
        FROM chore_settings cs
        INNER JOIN chores c ON cs.chore_id = c.id
        WHERE household_id = :householdId
    ');
        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $choreSettings = [];
        foreach ($results as $row) {
            $choreSettings[$row['chore_id']] = $row;
        }
        return $choreSettings;
    }
    public function updateChoreSettings($choreId, $timesInAWeek, $duration, $householdId) {
        $stmt = $this->database->connect()->prepare('
        UPDATE chore_settings 
        SET times_in_a_week = :timesInAWeek, duration = :duration
        WHERE chore_id = :choreId AND household_id = :householdId
    ');
        $stmt->bindParam(':timesInAWeek', $timesInAWeek, PDO::PARAM_INT);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
        $stmt->bindParam(':choreId', $choreId, PDO::PARAM_INT);
        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function deleteUserFromHousehold($userIdToDelete, $householdId)
    {
        $stmt = $this->database->connect()->prepare('
        DELETE FROM user_household WHERE "userID" = :userIdToDelete AND "householdID" = :householdId
    ');
        $stmt->bindParam(':userIdToDelete', $userIdToDelete, PDO::PARAM_INT);
        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();
    }


}