<?php
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
        $id = $hoje->format("Ym") . rand(100, 999); 
        $sql = "INSERT INTO cadastros (id, nome, sobrenome, email, senha) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("issss", $id, $nome, $sobrenome, $email, $senha_hash); 
        
        $stmt->execute();

        
        $mensagem_status = "<div class='mensagem sucesso'>Usuário cadastrado com sucesso!</div>";
        
        $stmt->close();
        $conn->close();
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
    <title>Cadastro</title>
    <link rel="stylesheet" href="./estilos/cadastrar.css">
    <link rel="stylesheet" href="./estilos/cabecalho.css">
</head>
<body>
    <div class="progresso-container">
        <div class="barra-progresso" id="progressoBarra"></div>
    </div>
    
    <header>
        <div class="logo">
             <a href="./index.html">
                <img src="./IMAGENS/LOGO (2).png" alt="Logo CM ESG" href="#index.html">
            </a>
        </div>
        <nav>
            <a href="index.html" class="home">Home</a>
            <a href="sobre.html" class="sobre">Sobre Desenvolvedores</a>
            <a href="faleconosco.html" class="contato">Fale Conosco</a>
            <a href="#" class="btn-cadastro">Cadastro</a>
        </nav>
    </header>

    <main>

        <div id="bloco-cadastro">
            
            <form action="cadastro.php" method="POST">
                <h1>CADASTRO</h1>
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
            </form>

            <form action="login.php" method="POST">
                <h1>LOGIN</h1>
                <p>Já tem uma conta? Entre aqui:</p>
                <input type="text" name="nome" id="nome">
                <input type="text" name="sobrenome" id="sobrenome">
                <input type="email" name="email" id="email">
                <input type="submit" value="Login">
            </form>
            
        </div>
    </main>

    <footer>
        <div class="direitos">
            <strong>&copy; 2025 CM - Camila e Maylon</strong>
        </div>
    </footer>
    <script src="progressoScroll.js"></script>
</body>
</html>