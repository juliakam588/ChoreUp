<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.id AS user_id, u.email, u.password, ud.name, ud.photo 
            FROM users u 
            LEFT JOIN users_details ud ON u.id_user_details = ud.id 
            WHERE u.email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }
        $role = $user['role'] ?? null;

        return new User(
            $user['user_id'],
            $user['email'],
            $user['password'],
            $user['name'],
            $user['photo'],
            $role

        );
    }

    public function getUserById(int $id): ?User
    {
        $stmt = $this->database->connect()->prepare('
        SELECT u.id AS user_id, u.email, ud.name, ud.photo 
        FROM users u 
        LEFT JOIN users_details ud ON u.id_user_details = ud.id 
        WHERE u.id = :id
    ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['user_id'],
            $user['email'],
            null,
            $user['name'],
            $user['photo'],
            null
        );
    }

    public function addUser(User $user) {
        $pdo = $this->database->connect();
        $pdo->beginTransaction();

        try {
            $stmt = $this->database->connect()->prepare('
            INSERT INTO users_details (name, photo) VALUES (?, ?) RETURNING id
        ');
            $stmt->execute([
                $user->getName(),
                $user->getPhoto()
            ]);

            $userDetailsId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

            $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, password, id_user_details) VALUES (?, ?, ?) RETURNING id
        ');
            $stmt->execute([
                $user->getEmail(),
                $user->getPassword(),
                $userDetailsId
            ]);

            $userId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
            $pdo->commit();
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }


    public function getUserDetailsId(User $user): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users_details WHERE name = :name AND photo = :photo
        ');
        $name = $user->getName();
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $photo = $user->getPhoto();
        $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function getUserRoles(int $userId): ?array {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM user_roles WHERE user_id = :userId
    ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($roles == false) {
            return null;
        }

        return $roles;
    }
}