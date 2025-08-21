<?php
// create_db.php
// Script de conveniência: cria o banco 'bibliotecapessoal' e importa database/schema.sql e seed.sql (se existirem).
// Acesse http://localhost/bibliotecapessoal/create_db.php no navegador.

ini_set('display_errors', 1);
error_reporting(E_ALL);

$dbHost = 'localhost';
$dbName = 'bibliotecapessoal';
$dbUser = 'root';
$dbPass = '';

echo "<h2>Criação do banco de dados: $dbName</h2>\n";

try {
    // conecta sem selecionar banco para criar o database
    $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo '<p style="color:crimson">Erro ao conectar ao MySQL: ' . htmlspecialchars($e->getMessage()) . '</p>';
    exit;
}

try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo '<p style="color:green">Banco criado/confirmado com sucesso.</p>';

    // conectar ao banco recém-criado
    $pdo->exec("USE `$dbName`");

    $schemaFile = __DIR__ . '/database/schema.sql';
    if (file_exists($schemaFile)) {
        $sql = file_get_contents($schemaFile);
        // separa statements por ponto-e-vírgula; executa cada um
        $stmts = array_filter(array_map('trim', explode(";", $sql)));
        foreach ($stmts as $s) {
            if ($s === '') continue;
            try {
                $pdo->exec($s);
            } catch (Exception $e) {
                // mostra erro mas continua
                echo '<p style="color:orange">Aviso ao executar statement: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
        }
        echo '<p style="color:green">Schema importado (database/schema.sql).</p>';
    } else {
        echo '<p>Arquivo schema.sql não encontrado em /database. Pulei import.</p>';
    }

    $seedFile = __DIR__ . '/database/seed.sql';
    if (file_exists($seedFile)) {
        $sql = file_get_contents($seedFile);
        $stmts = array_filter(array_map('trim', explode(";", $sql)));
        foreach ($stmts as $s) {
            if ($s === '') continue;
            try {
                $pdo->exec($s);
            } catch (Exception $e) {
                echo '<p style="color:orange">Aviso ao executar seed: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
        }
        echo '<p style="color:green">Seed importado (database/seed.sql).</p>';
    }

    echo '<p><a href="/bibliotecapessoal/">Ir para o site</a> — após confirmar que o site funciona, remova este arquivo (por segurança).</p>';

} catch (Exception $e) {
    echo '<p style="color:crimson">Erro: ' . htmlspecialchars($e->getMessage()) . '</p>';
}

?>
