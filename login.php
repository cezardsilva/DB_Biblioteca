<?php
session_start();
require 'conexao.php'; // Arquivo que conecta ao banco de dados

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'] ?? '';
    $senha = $_POST['senha'] ?? '';

    try {
        if (!$pdo) {
            throw new Exception("Falha na conexão com o banco de dados.");
        }

        // Consulta para buscar senha do usuário com base no nickname
        $stmt = $pdo->prepare("SELECT senha FROM usuarios WHERE nickname = ?");
        $stmt->execute([$nickname]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($senha, $resultado['senha'])) {
            $_SESSION['logado'] = true;
            $_SESSION['nickname'] = $nickname;

            // Redireciona todos os usuários para 'livros.php'
            header("Location: livros.php");
            exit;
        } else {
            $erro = "Nickname ou senha incorretos!";
        }
    } catch (PDOException $e) {
        $erro = "Erro no banco de dados: " . $e->getMessage();
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

// Se já estiver logado, redireciona
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header("Location: livros.php");
    exit;
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
    <link rel="stylesheet" href="login.css">
    
    <!-- Ícones preservados -->
    <link rel="icon" href="log-in.ico" type="image/ico">
    <link rel="shortcut icon" href="log-in.ico">
    <link rel="apple-touch-icon" href="log-in.ico">
    <title>Login - Sistema Biblioteca</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class='container'>
        <h1>Acesso ao Sistema</h1>

        <?php if(!empty($erro)): ?>
            <div class="erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="nickname">Nickname:</label>
            <input type="text" id="nickname" name="nickname" autocomplete="new-password" value="" required>

            <label for="senha">Senha:</label>
            <div class="senha-container">
                <input type="password" id="senha" name="senha" autocomplete="new-password" required>
                <i class="fas fa-eye toggle-password"></i>
            </div>
            <p><br></p>
            <button type="submit">Entrar</button>
        </form>
        <div class='menu'>
            <p><a href="cadastro.php">Cadastrar novo usuário</a></p>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("nickname").focus();
        });
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const senhaInput = document.getElementById('senha');
            const icon = this;
            senhaInput.type = senhaInput.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
