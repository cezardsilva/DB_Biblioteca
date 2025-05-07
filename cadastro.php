<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $nickname = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $data_nascimento = $_POST['data_nascimento'];
    $senha = $_POST['senha'];

    // Validação dos campos obrigatórios
    if (empty($nome) || empty($nickname) || empty($email) || empty($data_nascimento) || empty($senha)) {
        $erro = "Preencha todos os campos obrigatórios!";
    } else {
        // Validação e formatação da data
        $data_obj = DateTime::createFromFormat('d/m/Y', $data_nascimento);
        if (!$data_obj) {
            $erro = "Formato de data inválido! Use dd/mm/aaaa";
        } else {
            $data_banco = $data_obj->format('Y-m-d');
            $telefone_banco = preg_replace('/[^0-9]/', '', $telefone);
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            try {
                $stmt = $pdo->prepare("INSERT INTO usuarios (nome, nickname, email, telefone, data_nascimento, senha) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nome, $nickname, $email, $telefone_banco, $data_banco, $senha_hash]);
                $mensagem = "Cadastro realizado com sucesso!";
            } catch (PDOException $e) {
                $erro = "Erro no cadastro: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
 
    <link rel="stylesheet" href="cadastro.css">
    
    <!-- Ícones preservados -->
    <link rel="icon" href="user.ico" type="image/ico">
    <link rel="shortcut icon" href="user.ico">
    <link rel="apple-touch-icon" href="user.ico">

    <title>Cadastro de Usuário</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>
<body>
    
    <?php if(isset($mensagem)): ?>
        <div class="msg sucesso"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <div class="container">
        <?php if(isset($erro)): ?>
            <div class="msg erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form class="formulario" method="POST" id="formCadastro">
            <fieldset>
                <div class="leg">
                    <legend>Cadastro de Usuário</legend>
                </div>
                <div class="form-group">
                    <label for="nome">Nome completo*</label>
                    <input type="text" id="nome" name="nome" autocomplete="new-password" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="nickname">Nickname*</label>
                    <input type="text" id="nickname" name="nickname" autocomplete="new-password" value="<?= htmlspecialchars($_POST['nickname'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail*</label>
                    <input type="email" id="email" name="email" autocomplete="new-password" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" placeholder="(00)00000-0000" 
                        value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">
                </div>

                <div class="form-group date-container">
                    <label for="data_nascimento">Data de Nascimento*</label>
                    <input type="text" id="data_nascimento" name="data_nascimento" placeholder="dd/mm/aaaa" 
                        value="<?= htmlspecialchars($_POST['data_nascimento'] ?? '') ?>" required>
                    <i class="fas fa-calendar-alt"></i>
                </div>

                <div class="form-group" style="position:relative">
                    <label for="senha">Senha*</label>
                    <input class="senha-container" type="password" id="senha" name="senha" autocomplete="new-password" required>
                    <i class="fas fa-eye toggle-password"></i>
                </div>

                <button type="submit">Cadastrar</button>
            </fieldset>
        </form>
        <div class="menu">
            <p><a href="login.php">Ir para login</a></p>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Máscaras
            $('#telefone').mask('(00)0000-0000');
            $('#data_nascimento').mask('00/00/0000');
            
            // Datepicker com calendário
            $('#data_nascimento').datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '1900:+0',
                beforeShow: function(input, inst) {
                    inst.dpDiv.css({
                        'z-index': 9999,
                        'margin-top': '5px'
                    });
                }
            });

            // Alternar visibilidade da senha
            $('.toggle-password').click(function() {
                const senhaInput = $('#senha');
                senhaInput.attr('type', senhaInput.attr('type') === 'password' ? 'text' : 'password');
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            // Validação antes do envio
            $('#formCadastro').submit(function(e) {
                const dataInput = $('#data_nascimento');
                if (!/^\d{2}\/\d{2}\/\d{4}$/.test(dataInput.val())) {
                    alert('Data inválida! Use dd/mm/aaaa');
                    return false;
                }
                return true;
            });
        });

    </script>
    <script>
        // Revisão do script
        window.addEventListener("load", function() {
            console.log("rev 1.0");
        });
    </script>
</body>
</html>