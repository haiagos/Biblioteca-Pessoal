<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function register($data)
    {
        $user = new User();
        $result = $user->create($data);

        if ($result) {
            header("Location: /bibliotecapessoal/src/Views/auth/post-registration.php");
            exit();
        } else {
            // Handle registration failure (e.g., show an error message)
        }
    }

    public function getAllUsers()
    {
        $user = new User();
        return $user->getAll();
    }
}