<?php

class Chore
{
    private $choreId;
    private $choreName;

    public function getChoreId(): int
    {
        return $this->choreId;
    }

    public function setChoreId($choreId): void
    {
        $this->choreId = $choreId;
    }

    public function getChoreName(): string
    {
        return $this->choreName;
    }

    public function setChoreName($choreName): void
    {
        $this->choreName = $choreName;
    }

}