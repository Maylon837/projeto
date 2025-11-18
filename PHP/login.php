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
            <a href="index.php" class="Home">Home</a>
            <a href="faleconosco.html" class="contato">Fale Conosco</a>
            
            <?php
        if (isset($_SESSION['user_id'])): 
            ?>
            <div class="menu-perfil">
                <button id="btn-perfil" onclick="toggleMenu()">
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