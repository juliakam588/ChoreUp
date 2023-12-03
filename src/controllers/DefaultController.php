<?php

require_once 'AppController.php';


require_once __DIR__ .'/../models/Dog.php'; 


class DefaultController extends AppController {

    public function login()
    {

        $this->render('login');
    }

    public function registration() {
        $this->render('registration');
    }

    
    public function afterRegistration() {
        $this->render('afterRegistration');
    }


    public function dashboard() {
        $this->render('dashboard');
    }

    public function household() {
        $this->render('household');
    }
}