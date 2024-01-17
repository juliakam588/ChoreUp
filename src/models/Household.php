<?php

class Household {
    private $householdId;
    private $householdCode;

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


}