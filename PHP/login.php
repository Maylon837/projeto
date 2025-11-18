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
    
    <header>
        <div class="logo">
             <a href="./index.php">
                <img src="../IMAGENS/logo-branca.png" alt="Logo CM ESG" href="#index.php">
            </a>
        </div>
        <nav>
            <a href="./index.php" class="home">Home</a>
            <a href="./faleconosco.html" class="contato">Fale Conosco</a>
            <a href="./cadastro.php" class="btn-cadastro">Cadastro</a>
            <a href="#" class="btn-login">Login</a>
        </nav>
    </header>

    <main>
        
        <div id="bloco-login">
            <form action="login.php" method="POST">
                <h1>LOGIN</h1>
                <p>Faça seu login:</p>

                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email">

                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha">

                <input type="submit" value="Login">

                <p class="btn-rapido">Não tem um cadastro? <a href="cadastro.php">Faça um cadastro</a>.</p>
            </form>

        </div>

    </main>

    <footer> 
        <div class="direitos">
            <strong>&copy;2025 CM - Camila e Maylon</strong> 
        </div>
    </footer>

    <script src="../JS/progressoScroll.js"></script>
</body>
</html>