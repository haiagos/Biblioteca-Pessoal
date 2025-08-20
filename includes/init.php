<?php
// Inicialização da aplicação: sessão, persistência e handlers de auth
session_start();

$usersFile = __DIR__ . '/../data/users.json';
if (!file_exists($usersFile)) {
    @mkdir(dirname($usersFile), 0777, true);
    file_put_contents($usersFile, json_encode([]));
}

function load_users($file)
{
    $data = @file_get_contents($file) ?: '[]';
    $users = json_decode($data, true);
    return is_array($users) ? $users : [];
}

function save_users($file, $users)
{
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function find_user($users, $email)
{
    foreach ($users as $u) {
        if (isset($u['email']) && strtolower($u['email']) === strtolower($email)) {
            return $u;
        }
    }
    return null;
}

$errors = [];
$success = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $action = $_POST['action'] ?? '';
    $email = trim($_POST['email'] ?? '');
    if ($action === 'register') {
        $name = trim($_POST['name'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($name === '' || $email === '' || $password === '') {
            $errors[] = 'Preencha todos os campos.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'E-mail inválido.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'A senha deve ter pelo menos 6 caracteres.';
        } else {
            $users = load_users($usersFile);
            if (find_user($users, $email)) {
                $errors[] = 'E-mail já cadastrado.';
            } else {
                $users[] = [
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'createdAt' => date('c'),
                ];
                save_users($usersFile, $users);
                $success = 'Cadastro realizado com sucesso. Faça login.';
            }
        }
    } elseif ($action === 'login') {
        $password = $_POST['password'] ?? '';
        $users = load_users($usersFile);
        $u = find_user($users, $email);
        if (!$u || !password_verify($password, $u['password'])) {
            $errors[] = 'Credenciais inválidas.';
        } else {
            $_SESSION['user'] = [
                'name' => $u['name'],
                'email' => $u['email'],
            ];
            header('Location: ' . ($_SERVER['PHP_SELF'] ?? '/'));
            exit;
        }
    } elseif ($action === 'logout') {
        $_SESSION = [];
        if (session_id() !== '') {
            session_destroy();
        }
        header('Location: ' . ($_SERVER['PHP_SELF'] ?? '/'));
        exit;
    }
}
