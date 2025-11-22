<?php
session_start();
$mensagem_status = "";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include("conexao.php");

        $email_form = $_POST["email"];
        $senha_form = $_POST["senha"];

        $sql = "SELECT id, senha FROM cadastros WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email_form);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            $senha_hash = $usuario['senha']; 

            if (password_verify($senha_form, $senha_hash)) {

                $_SESSION['user_id'] = $usuario['id']; 
                $_SESSION['email'] = $email_form;
                $_SESSION['login_sucesso'] = true; 

            } else {
                
                $mensagem_status = "<div class='mensagem-erro'>Erro: Senha incorreta.</div>";
            }
        } else {
            $mensagem_status = "<div class='mensagem-erro'>Erro: Usuário não encontrado com este e-mail.</div>";
        }

        $stmt->close();
        $conn->close();
    }
} catch (Exception $e) {
    $mensagem_status = "<div class='mensagem-erro'>Erro no Login: " . $e->getMessage() . "</div>";
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
                    <button id="btn-perfil" onclick="toggleMenu()" class="home">Conta</button>
                    <div id="menu-opcoes" class="menu-perfil-opcoes">
                        <a href="configuracoes.php" class="menu-perfil-link">Configurações</a>
                        <a href="excluir_conta.php" class="menu-perfil-link" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível!');">Excluir conta</a>
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

            <div class="bloco-mensagem">
                <h2>Login Realizado com Sucesso!</h2>
                <p>Obrigado por fazer seu login. Você agora está logado na sua conta.</p>

                <a href="../PHP/index.php" class="btn-principal">
                    Voltar para a Página Principal
                </a>
            </div>

        <?php } else { ?>

            <div id="bloco-login">
                <form action="login.php" method="POST" class="form-login">
                    <h1>🔓Login</h1>
                    <p>Faça seu login:</p>

                    <label for="email"><strong>E-mail:</strong></label>
                    <input type="email" name="email" id="email" required placeholder="Digite seu e-mail">

                    <label for="senha"><strong>Senha:</strong></label>
                    <input type="password" name="senha" id="senha" required placeholder="Digite sua senha">
                    <?php echo $mensagem_status; ?>
                    <input type="submit" value="Login">

                    <p class="btn-rapido">Não tem um cadastro? <a href="cadastro.php">Faça um cadastro.</a></p>
                    
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