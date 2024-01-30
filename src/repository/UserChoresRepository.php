<?php

require_once __DIR__ . '/../models/User.php';
require_once 'Repository.php';

class UserChoresRepository extends Repository
{
    public function assignChoreToUser($userId, $choreId, $statusId, $dateScheduled, $scheduleId)
    {
        $stmt = $this->database->connect()->prepare('INSERT INTO user_chores ("userID", "choreID", "statusID", "dateScheduled", "schedule_id") VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$userId, $choreId, $statusId, $dateScheduled, $scheduleId]);
    }

    public function updateChoreStatus($choreId, $statusId) {
        try {
            $stmt = $this->database->connect()->prepare('
            UPDATE user_chores SET "statusID" = :statusId WHERE id = :choreId
        ');
            $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);
            $stmt->bindParam(':choreId', $choreId, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }


    public function updateUserChore($userChoreId, $userId, $dayName)
    {
        $dateScheduled = $this->convertDayNameToDate($dayName);


        $stmt = $this->database->connect()->prepare('
        UPDATE user_chores SET "userID" = :userId, "dateScheduled" = :dateScheduled WHERE id = :userChoreId
    ');

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':dateScheduled', $dateScheduled, PDO::PARAM_STR);
        $stmt->bindParam(':userChoreId', $userChoreId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteUserChore($userChoreId) {
        $stmt = $this->database->connect()->prepare('
        DELETE FROM user_chores WHERE id = :userChoreId
    ');
        $stmt->bindParam(':userChoreId', $userChoreId, PDO::PARAM_INT);
        $stmt->execute();
    }
    private function convertDayNameToDate($dayName): string
    {
        $date = new DateTime();
        $date->modify('next ' . $dayName);
        return $date->format('Y-m-d');
    }

    public function getUserChoreDetails($userChoreId)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT uc.*, c.name as chore_name, ud.name as user_name, ud.photo as user_photo
        FROM user_chores uc
        JOIN chores c ON uc."choreID" = c.id
        JOIN users u ON uc."userID" = u.id
        JOIN users_details ud ON u.id_user_details = ud.id
        WHERE uc.id = :userChoreId
    ');
        $stmt->bindParam(':userChoreId', $userChoreId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveScheduleToDatabase($schedule, $scheduleId)
    {
        foreach ($schedule as $dayName => $data) {
            foreach ($data['tasks'] as $task) {
                $dateScheduled = $this->convertDayNameToDate($dayName);
                $stmt = $this->database->connect()->prepare('
            INSERT INTO user_chores ("userID", "choreID", "statusID", "dateScheduled", "schedule_id") 
            VALUES (:userId, :choreId, 1, :dateScheduled, :scheduleId)
        ');

                $stmt->bindParam(':userId', $task['user_id'], PDO::PARAM_INT);
                $stmt->bindParam(':choreId', $task['chore_id'], PDO::PARAM_INT);
                $stmt->bindParam(':dateScheduled', $dateScheduled, PDO::PARAM_STR);
                $stmt->bindParam(':scheduleId', $scheduleId, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    }

    public function getCompletedTasksCount($householdId) {
        $stmt = $this->database->connect()->prepare('
        SELECT COUNT(*) as total_count
        FROM user_chores uc
        JOIN schedules s ON uc.schedule_id = s.id
        WHERE s.household_id = :householdId AND uc."statusID" = 2
        AND s.id = (
            SELECT id FROM schedules
            WHERE household_id = :householdId
            ORDER BY created_at DESC
            LIMIT 1
        )
    ');
        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_count'] ?? 0;
    }
}