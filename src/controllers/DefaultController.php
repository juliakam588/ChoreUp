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

    public function chores() {
        $this->render('chores');
    }
    
    public function chore_mopping() {
        $this->render('chore_mopping');
    }

    public function chore_vacuum() {
        $this->render('chore_vacuum');
    }

    public function chore_rubbish() {
        $this->render('chore_rubbish');
    }
    public function edit() {
        $this->render('edit');
    }
}