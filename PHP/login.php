<?php
session_start();
$mensagem_status = "";

try {
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include("conexao.php");

        // Captura os dados de login
        $email_form = $_POST["email"];
        $senha_form = $_POST["senha"];

        // 1. Consulta o banco de dados para encontrar o usuário pelo e-mail
        $sql = "SELECT id, senha FROM cadastros WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email_form);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // 2. Verifica se encontrou o usuário
        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            $senha_hash = $usuario['senha']; // Hash armazenado no banco

            // 3. Verifica a senha usando password_verify()
            if (password_verify($senha_form, $senha_hash)) {

                // LOGIN BEM-SUCEDIDO:
                $_SESSION['user_id'] = $usuario['id']; // Define a sessão
                $_SESSION['email'] = $email_form;
                $_SESSION['login_sucesso'] = true; // Define uma flag de sucesso

            } else {
                // Senha incorreta
                $mensagem_status = "<div class='mensagem erro'>Erro: Senha incorreta.</div>";
            }
        } else {
            // Usuário não encontrado
            $mensagem_status = "<div style= 'color: red; padding: 5px; padding-left: 10px; width: 30em; margin-left: 20px; background-color: rgba(255, 197, 197, 1); border: 1px solid rgb(243, 137, 137); border-radius: 5px; font-family: Arial;'>
            Erro: Usuário não encontrado com este e-mail.</div>";
        }

        $stmt->close();
        $conn->close();
    }
} catch (Exception $e) {
    $mensagem_status = "<div class='mensagem erro'>Erro no Login: " . $e->getMessage() . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/cabecalho.css">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="progresso-container">
        <div class="barra-progresso" id="progressoBarra"></div>
    </div>

    <header class="logo">
        <a href="../index.php">
            <img src="../IMAGENS/logo-branca.png" alt="Logo CM ESG" href="#index.php">
        </a>

        <nav>
            <a href="index.php" class="home">Home</a>
            <a href="../PHP/index.php" class="contato">Fale Conosco</a>
            <?php
            if (isset($_SESSION['user_id'])):
            ?>
                <div class="menu-perfil">
                    <button id="btn-perfil" class="btn-conta" onclick="toggleMenu()" >Conta</button>
                    <div id="menu-opcoes" class="menu-perfil-opcoes">
                        <a href="configuracoes.php" class="menu-perfil-link">Configurações</a>
                        <a href="logout.php" class="menu-perfil-link">Sair</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="cadastro.php" class="btn-cadastro">Cadastro</a>
                <a href="login.php" class="btn-login">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php
        if (isset($_SESSION['login_sucesso']) && $_SESSION['login_sucesso'] === true) {
            unset($_SESSION['login_sucesso']);
        ?>

            <div class="bloco-mensagem" style="text-align: center; padding: 50px; border: 1px solid #ccc; max-width: 450px; margin: 80px auto; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <h2>Login Realizado com Sucesso!</h2>
                <p style="margin-bottom: 25px;">Obrigado por fazer seu login. Você agora está logado na sua conta.</p>

                <a href="../PHP/index.php" class="btn-principal" style="text-decoration: none; padding: 10px 20px; background-color: #007bff; color: white; border-radius: 5px; font-weight: bold; display: inline-block;">
                    Voltar para a Página Principal
                </a>
            </div>

        <?php } else { ?>

            <div id="bloco-login">
                <form action="login.php" method="POST" class="form-login">
                    <h1>LOGIN</h1>
                    <p>Faça seu login:</p>

                    <label for="email"><strong>E-mail:</strong></label>
                    <input type="email" name="email" id="email" required placeholder="Digite seu e-mail">

                    <label for="senha"><strong>Senha:</strong></label>
                    <input type="password" name="senha" id="senha" required placeholder="Digite sua senha">

                    <input type="submit" value="Login">

                    <p class="btn-rapido">Não tem um cadastro? <a href="cadastro.php">Faça um cadastro.</a></p>
                    <?php echo $mensagem_status; ?>
                </form>
            </div>

        <?php } ?>
    </main>

    <footer>
        <div class="direitos">
            <strong>&copy;2025 CM - Todos os direitos reservados</strong>
        </div>
    </footer>

    <script src="../JS/progressoScroll.js"></script>
</body>

</html>