<?php
session_start();

// Configuração do banco de dados
$dbHost = 'localhost';
$dbName = 'bibliotecapessoal';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}

$errors = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            // Verifica se já existe
            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errors[] = 'E-mail já cadastrado.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
                $stmt->execute([$name, $email, $hash]);
                    $_SESSION['user'] = [
                        'name' => $name,
                        'email' => $email,
                    ];
                    // Redireciona para a home (dashboard será exibido quando logado)
                    header('Location: /bibliotecapessoal/');
                    exit;
            }
        }
    }

    if ($action === 'login') {
        $password = $_POST['password'] ?? '';
        $stmt = $pdo->prepare('SELECT name, email, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $u = $stmt->fetch();
        if (!$u || !password_verify($password, $u['password'])) {
            $errors[] = 'Credenciais inválidas.';
        } else {
            $_SESSION['user'] = [
                'name' => $u['name'],
                'email' => $u['email'],
            ];
                // Redireciona para a home (dashboard)
                header('Location: /bibliotecapessoal/');
                exit;
        }
    }

    if ($action === 'logout') {
        $_SESSION = [];
        if (session_id() !== '') {
            session_destroy();
        }
        header('Location: /bibliotecapessoal/index.php');
        exit;
    }

        // Permite adicionar itens simples (livro, filme, tarefa) gravados em JSON localmente
        if ($action === 'add_item') {
            if (!isset($_SESSION['user'])) {
                $errors[] = 'Você precisa estar logado para adicionar itens.';
            } else {
                $type = $_POST['type'] ?? '';
                $title = trim($_POST['title'] ?? '');
                $notes = trim($_POST['notes'] ?? '');
                $author = trim($_POST['author'] ?? '');
                $year = trim($_POST['year'] ?? '');
                $cover = trim($_POST['cover'] ?? '');
                if ($type === '' || $title === '') {
                    $errors[] = 'Preencha o tipo e o título do item.';
                } else {
                    $dataFile = __DIR__ . '/../data/items.json';
                    $items = [];
                    if (file_exists($dataFile)) {
                        $items = json_decode(file_get_contents($dataFile), true) ?: [];
                    }
                    $items[] = [
                        'id' => uniqid('', true),
                        'user' => $_SESSION['user']['email'],
                        'type' => $type,
                        'title' => $title,
                        'author' => $author,
                        'year' => $year,
                        'cover' => $cover,
                        'notes' => $notes,
                        'createdAt' => date('c'),
                    ];
                    file_put_contents($dataFile, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    // flash de sucesso via sessao para exibir toast apos redirect
                    $_SESSION['flash_success'] = 'Item adicionado com sucesso.';
                    header('Location: /bibliotecapessoal/');
                    exit;
                }
            }
        }
}
