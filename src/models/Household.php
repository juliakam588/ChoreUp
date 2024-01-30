<?php

class Household {
    private $householdId;
    private $householdCode;
    private $users;

    public function __construct($householdId, $householdCode)
    {
        $this->householdId = $householdId;
        $this->householdCode = $householdCode;
    }


    public function getHouseholdId(): int
    {
        return $this->householdId;
    }

    public function setHouseholdId($householdId): void
    {
        $this->householdId = $householdId;
    }

    public function getHouseholdCode(): string
    {
        return $this->householdCode;
    }

    public function setHouseholdCode($householdCode): void
    {
        $this->householdCode = $householdCode;
    }

    public function getUsers(): array {
        return $this->users;
    }

    public function setUsers(array $users): void {
        $this->users = $users;
    }

}