<?php
function redirect($url) {
    header("Location: $url");
    exit();
}

function validateUserData($data) {
    // Implement validation logic here
    return true; // Return true if valid, false otherwise
}

function saveUserData($data) {
    $filePath = __DIR__ . '/../data/users.json';
    $users = json_decode(file_get_contents($filePath), true);
    $users[] = $data;
    file_put_contents($filePath, json_encode($users));
}
?>