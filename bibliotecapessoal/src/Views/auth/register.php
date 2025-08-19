<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $usersFile = 'C:/xampp/htdocs/bibliotecapessoal/data/users.json';
        $users = json_decode(file_get_contents($usersFile), true);

        $newUser = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $users[] = $newUser;
        file_put_contents($usersFile, json_encode($users));

        header('Location: post-registration.php');
        exit();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<?php include '../layouts/header.php'; ?>

<h2>Register</h2>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Register</button>
</form>

<?php include '../layouts/footer.php'; ?>