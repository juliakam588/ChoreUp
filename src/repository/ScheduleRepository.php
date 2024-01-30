<?php
require_once 'Repository.php';
require_once __DIR__.'/../models/Task.php';


class ScheduleRepository extends Repository
{
    public function createSchedule($householdId, $startDate, $endDate)
    {
        $stmt = $this->database->connect()->prepare('INSERT INTO schedules (household_id, start_date, end_date) VALUES (?, ?, ?) RETURNING id');
        $stmt->execute([$householdId, $startDate, $endDate]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public function getLastScheduleForHousehold($householdId) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM schedules 
            WHERE household_id = :householdId 
            ORDER BY created_at DESC 
            LIMIT 1
        ');
        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getScheduleTasks($householdId): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT uc.id as user_chore_id,
               c.id as chore_id, 
               c.name as chore_name, 
               cs.description as chore_status, 
               u.id as user_id, 
               u.email, 
               ud.name as user_name, 
               ud.photo as user_photo, 
               get_day_name(uc."dateScheduled") as day_name, 
               CASE WHEN uc."statusID" = 2 THEN true ELSE false END as is_completed
        FROM user_chores uc 
        JOIN chores c ON uc."choreID" = c.id 
        JOIN chore_status cs ON uc."statusID" = cs.id
        JOIN users u ON uc."userID" = u.id 
        JOIN users_details ud ON u.id_user_details = ud.id 
        WHERE uc.schedule_id = (
            SELECT id FROM schedules 
            WHERE household_id = :householdId 
            ORDER BY created_at DESC 
            LIMIT 1
        )
        ORDER BY uc."dateScheduled" ASC
    ');
        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();

        $tasksData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tasks = [];
        foreach ($tasksData as $taskData) {
            $user = new User(
                $taskData['user_id'],
                $taskData['email'],
                null,
                $taskData['user_name'],
                $taskData['user_photo'],
                null
            );
            $chore = new Chore(
                $taskData['chore_id'],
                $taskData['chore_name']
            );

            $task = new Task(
                $taskData['user_chore_id'],
                $user,
                $chore,
                $taskData['chore_status'],
                $taskData['day_name']
            );
            $tasks[] = $task;
        }
        return $tasks;
    }

    public function getTasksCount($householdId) {
        $stmt = $this->database->connect()->prepare('
        SELECT COUNT(*) as "totalTasks"
        FROM user_chores
        WHERE schedule_id = (
            SELECT id FROM schedules 
            WHERE household_id = :householdId 
            ORDER BY created_at DESC 
            LIMIT 1
        )
    ');
        $stmt->bindParam(':householdId', $householdId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTaskUserId($taskId, $newUserId) {
        $stmt = $this->database->connect()->prepare('
        UPDATE user_chores SET "userID" = :newUserId WHERE id = :taskId
    ');
        $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
        $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $stmt->execute();
    }
}