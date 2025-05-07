<?php
// SEMPRE a primeira linha do arquivo
session_start();

require 'conexao.php'; // Usa o MESMO arquivo de conexão do cadastro de usuários

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verifica se a tabela está correta (evita erro no servidor)
        $stmt = $pdo->query("SHOW COLUMNS FROM livros WHERE `Key` = 'PRI'");
        $primaryKey = $stmt->fetch();
        
        if (!$primaryKey) {
            throw new Exception("A tabela 'livros' não tem chave primária definida");
        }

        // Faz o INSERT (funciona em ambos ambientes)
        $stmt = $pdo->prepare("INSERT INTO livros (nome, autor, edicao, estilo) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nome'],
            $_POST['autor'],
            $_POST['edicao'],
            $_POST['estilo']
        ]);
        
        $_SESSION['msg'] = ['texto' => 'Livro cadastrado com sucesso!', 'tipo' => 'sucesso'];
    } catch (Exception $e) {
        $_SESSION['msg'] = ['texto' => 'Erro: ' . $e->getMessage(), 'tipo' => 'erro'];
    }
    
    header("Location: formulario.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="formulario.css">
    <link rel="icon" href="book.ico" type="image/ico">
    <link rel="shortcut icon" href="book.ico">
    <link rel="apple-touch-icon" href="book.ico">
    <title>Biblioteca</title>
</head>
<body>
    <div class="container">
        <form class="formulario" action="formulario.php" method="post">
            <fieldset>
                <div class="leg">
                    <legend>Cadastro de Livros</legend>
                </div>
                <div class="form-group">
                    <label for="nome">Nome do Livro:</label>
                    <input type="text" id="nome" name="nome" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="autor">Autor:</label>
                    <input type="text" id="autor" name="autor" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="edicao">Edição:</label>
                    <input type="text" id="edicao" name="edicao" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="estilo">Estilo:</label>
                    <input type="text" id="estilo" name="estilo" autocomplete="off" required>
                </div>
                <button type="submit">Cadastrar Livro</button>
            </fieldset>
        </form>
        <div class="menu">
            <p>
                <a href="logout.php">Sair</a> | 
                <a href="livros.php">Gerenciamento de livros</a> | 
                <a href="formulario.php">Cadastro de livros</a>
                <?php if (isset($_SESSION['nickname']) && in_array($_SESSION['nickname'], ['sysadmin', 'root'])): ?>
                    | <a href="usuarios.php">Cadastro de Usuários</a>
                <?php endif; ?>
            </p>
        </div>

        <?php
        if (isset($_SESSION['msg'])) {
            echo "<div class='msg {$_SESSION['msg']['tipo']}'>{$_SESSION['msg']['texto']}</div>";
            unset($_SESSION['msg']);
        }
        ?>
    </div>

    <script>
        // Controle de versão 
        window.addEventListener("load", function() {
            console.log("rev 1.6");
        });

        // Foco no campo 'nome'
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("nome").focus();
        });

        // Mensagem que desaparece após 3 segundos
        document.addEventListener("DOMContentLoaded", function() {
            var msgElement = document.querySelector(".msg");
            if (msgElement) {
                setTimeout(function() {
                    msgElement.style.transition = "opacity 0.5s";
                    msgElement.style.opacity = "0";
                    setTimeout(function() {
                        msgElement.remove();
                    }, 500);
                }, 3000);
            }
        });

        // Formatação do estilo (maiúscula inicial)
        document.addEventListener("DOMContentLoaded", function() {
            var estiloInput = document.getElementById("estilo");
            if (estiloInput) {
                estiloInput.addEventListener("input", function() {
                    if (this.value.length > 0) {
                        this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();
                    }
                });
            }
        });
    </script>
</body>
</html>