<?php
session_start();
$mensagem_status = "";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include("conexao.php");

        $nome = $_POST["nome"];
        $sobrenome = $_POST["sobrenome"];
        $email = $_POST["email"];
        $senha_pura = $_POST["senha"];
        $senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);

        $hoje = new DateTime();
        $id = $hoje->format("ym") . rand(100, 999);

        $sql = "INSERT INTO cadastros (id, nome, sobrenome, email, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $id, $nome, $sobrenome, $email, $senha_hash);
        $stmt->execute();

        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $email;

        $_SESSION['cadastro_sucesso'] = true; // Define uma flag de sucesso
    }
} catch (Exception $e) {
    if (strpos($e->getMessage(), "Duplicate entry") !== false) {
        $mensagem_status = "<div style= 'color: red; padding: 5px; padding-left: 10px; width: 30em; margin-left: 25px; background-color: rgba(255, 197, 197, 1); border: 1px solid rgb(243, 137, 137); border-radius: 5px;'>
        Erro ao cadastrar: Email já registrado. Tente outro.</div>";
    } else {
        $mensagem_status = "<div style= 'color: red; padding: 5px; padding-left: 10px; width: 30em; margin-left: 25px; background-color: rgba(255, 197, 197, 1); border: 1px solid rgb(243, 137, 137); border-radius: 5px;'>
        Erro ao cadastrar: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Projeto ESG</title>
    <link rel="stylesheet" href="../css/cadastrar.css">
    <link rel="stylesheet" href="../css/cabecalho.css">
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

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="menu-perfil">
                    <button id="btn-perfil" class="btn-conta" onclick="toggleMenu()" >
                        Conta
                    </button>
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
        if (isset($_SESSION['cadastro_sucesso']) && $_SESSION['cadastro_sucesso'] === true) {
            unset($_SESSION['cadastro_sucesso']);
        ?>

            <div class="bloco-mensagem">
                <h2>Cadastro Concluído!</h2>
                <p>Seja bem-vindo(a)! Você agora está logado na sua conta.</p>

                <a href="../PHP/index.php" class="btn-principal">
                    Voltar para a Página Principal
                </a>
            </div>
            
        <?php } else { ?>

            <div id="bloco-cadastro">
                <form action="cadastro.php" method="POST">
                    <h1>CADASTRO</h1>
                    <p>Não está cadastrado? Faça seu cadastro aqui:</p>

                    <label for="nome"><strong>Nome:</strong></label>
                    <input type="text" name="nome" id="nome" required placeholder="Digite seu nome">

                    <label for="sobrenome"><strong>Sobrenome:</strong></label>
                    <input type="text" name="sobrenome" id="sobrenome" required placeholder="Digite seu sobrenome">

                    <label for="email"><strong>E-mail:</strong></label>
                    <input type="email" name="email" id="email" required placeholder="Digite seu e-mail">

                    <label for="senha"><strong>Senha:</strong></label>
                    <input type="password" name="senha" id="senha" required placeholder="Digite sua senha">
                    <?php echo $mensagem_status; ?> 
                    <input type="submit" value="Cadastrar">
                     
                    
                    <p class="btn-rapido">Já tem um cadastro? <a href="login.php">Faça login.</a></p>
                </form>
            </div>

        <?php } ?>
    </main>

    <footer>
        <div class="direitos">
            <strong>&copy;2025 CM - Todos os direitos reservados</strong>
        </div>
    </footer>
    <script src="../JS/progresscroll.js"></script>
</body>

</html>