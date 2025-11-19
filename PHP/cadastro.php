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
        $mensagem_status = "<div class='mensagem erro'>Erro ao cadastrar: Email já registrado. Tente outro.</div>";
    } else {
        $mensagem_status = "<div class='mensagem erro'>Erro ao cadastrar: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Projeto ESG</title>

    <link rel="stylesheet" href="../CSS/cadastrar.css">
    <link rel="stylesheet" href="../CSS/cabecalho.css">
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
                    <button id="btn-perfil" onclick="toggleMenu()" class="home">
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

            <div class="bloco-mensagem" style="text-align: center; padding: 50px; border: 1px solid #ccc; max-width: 450px; margin: 80px auto; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <h2>Cadastro Concluído!</h2>
                <p style="margin-bottom: 25px;">Seja bem-vindo(a)! Você agora está logado na sua conta.</p>

                <a href="../PHP/index.php" class="btn-principal" style="text-decoration: none; padding: 10px 20px; background-color: #007bff; color: white; border-radius: 5px; font-weight: bold; display: inline-block;">
                    Voltar para a Página Principal
                </a>
            </div>

        <?php } else { ?>

            <div id="bloco-cadastro">
                <form action="cadastro.php" method="POST">
                    <?php echo $mensagem_status; ?> <h1>CADASTRO</h1>
                    <p>Não está cadastrado? Faça seu cadastro aqui:</p>

                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" required>

                    <label for="sobrenome">Sobrenome:</label>
                    <input type="text" name="sobrenome" id="sobrenome" required>

                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" required>

                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" required>

                    <input type="submit" value="Cadastrar">

                    <p class="btn-rapido">Já tem um cadastro? <a href="login.php">Faça login.</a></p>
                </form>
            </div>

        <?php } ?>
    </main>

    <footer>
        <div class="direitos">
            <strong>&copy; 2025 CM - Camila e Maylon</strong>
        </div>
    </footer>
    <script src="../JS/progresscroll.js"></script>
</body>

</html>