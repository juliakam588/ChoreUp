<?php

class Task {
    private $id;
    private $user;
    private $chore;
    private $status;
    private $dayName;

    public function __construct($id, User $user, Chore $chore, $status, $dayName) {
        $this->id = $id;
        $this->user = $user;
        $this->chore = $chore;
        $this->status = $status;
        $this->dayName = $dayName;
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }


    public function getChore(): Chore
    {
        return $this->chore;
    }


    public function setChore(Chore $chore): void
    {
        $this->chore = $chore;
    }

    public function getStatus()
    {
        return $this->status;
    }


    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getDayName()
    {
        return $this->dayName;
    }


    public function setDayName($dayName): void
    {
        $this->dayName = $dayName;
    }

}