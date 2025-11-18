<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/cadastrar.css">
    <link rel="stylesheet" href="../css/cabecalho.css">
</head>
<body>
     <div class="progresso-container">
        <div class="barra-progresso" id="progressoBarra"></div>
    </div>
    
    <header>
        <div class="logo">
             <a href="./index.php">
                <img src="../IMAGENS/LOGO (2).png" alt="Logo CM ESG" href="#index.php">
            </a>
        </div>
        <nav>
            <a href="./index.php" class="home">Home</a>
            <a href="./faleconosco.php" class="contato">Fale Conosco</a>
            <a href="#" class="btn-cadastro">Cadastro</a>
            <a href="./login.php" class="btn-login">Login</a>
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

                <p class="btn-rapido">Já tem um cadastro? <a href="login.php">Faça login</a>.</p>
            </form>
        

        </div>
    </main>

    <footer>
        <div class="direitos">
            <strong>&copy; 2025 CM - Camila e Maylon</strong>
        </div>
    </footer>
    <script src="../JS/progressoScroll.js"></script>
</body>
</html>