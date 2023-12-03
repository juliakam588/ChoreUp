<?php

class User{
    private $email;
    private $password;
    private $name;



    public function __construct(string $email, string $password, string $name) {
    
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function getPassword()
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

}

