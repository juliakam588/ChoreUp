<?php

class User
{
    private $id;
    private $email;
    private $password;
    private $name;
    private $photo;
    private $role;


    public function __construct($id, $email, $password, $name, $photo, $role)
    {

        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->photo = $photo;
        $this->role = $role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }


    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole($role): void
    {
        $this->role = $role;
    }


}

