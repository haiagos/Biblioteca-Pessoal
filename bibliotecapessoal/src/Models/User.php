<?php

class User {
    private $dataFile;

    public function __construct() {
        $this->dataFile = __DIR__ . '/../../data/users.json';
    }

    public function register($userData) {
        $users = $this->getAllUsers();
        $users[] = $userData;
        file_put_contents($this->dataFile, json_encode($users));
    }

    public function getAllUsers() {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        $jsonData = file_get_contents($this->dataFile);
        return json_decode($jsonData, true);
    }

    public function findUserByEmail($email) {
        $users = $this->getAllUsers();
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }
}