<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function register($data)
    {
        // Validate the registration data
        if ($this->validateRegistration($data)) {
            // Create a new user
            $user = new User();
            $user->create($data);

            // Redirect to post-registration page
            header("Location: /bibliotecapessoal/src/Views/auth/post-registration.php");
            exit();
        } else {
            // Handle validation errors
            // You can redirect back to the registration page with error messages
        }
    }

    private function validateRegistration($data)
    {
        // Implement validation logic here
        // Return true if valid, false otherwise
        return true; // Placeholder
    }

    public function login($data)
    {
        // Implement login logic here
    }
}