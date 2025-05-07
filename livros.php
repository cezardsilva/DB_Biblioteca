<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

$config = require 'config.php';

try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ]);

    // Consulta todos os livros cadastrados
    $stmt = $pdo->query("SELECT id_livro, nome, autor, edicao, estilo FROM livros");
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="livros.css">

    <!-- Ícones preservados -->
    <link rel="icon" href="books.ico" type="image/ico">
    <link rel="shortcut icon" href="books.ico">
    <link rel="apple-touch-icon" href="books.ico">
    <title>Lista de Livros</title>

</head>
<body>
    <div class='container'>
        <h1>Livros Cadastrados</h1>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Autor</th>
                <th>Edição</th>
                <th>Estilo</th>
            </tr>
            <?php foreach ($livros as $livro): ?>
                <tr>
                <tr>
                    <td><?= $livro['id_livro'] ?></td>
                    <td><?= htmlspecialchars($livro['nome']) ?></td>
                    <td><?= htmlspecialchars($livro['autor']) ?></td>
                    <td><?= ucfirst(strtolower(htmlspecialchars($livro['edicao']))) ?></td>
                    <td><?= ucfirst(strtolower(htmlspecialchars($livro['estilo']))) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <p class='menu'>
            <a href="logout.php">Sair</a> | 
            <a href="livros.php">Gerenciamento de livros</a> | 
            <a href="formulario.php">Cadastro de livros</a>
            <?php if (isset($_SESSION['nickname']) && in_array($_SESSION['nickname'], ['sysadmin', 'root'])): ?>
                | <a href="usuarios.php">Cadastro de Usuários</a>
            <?php endif; ?>
        </p>

    </div>
    <script>
        // Revisão do script
        window.addEventListener("load", function() {
            console.log("rev 1.2");
        });
    </script>    
</body>
</html>
