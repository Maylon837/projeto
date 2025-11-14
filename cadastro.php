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
                <img src="./IMAGENS/logo (2).png" alt="Logo CM ESG" href="#index.html">
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
                <input type="text" name="nome" id="nome">

                <label for="sobrenome">Sobrenome:</label>
                <input type="text" name="sobrenome" id="sobrenome">
                
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email">

                <input type="submit" value="Cadastrar">

            </form>
        
            <form action="login.php" method="POST">
                <h1>LOGIN</h1>
                <p>Já tem uma conta? Entre aqui:</p>

                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome">

                <label for="sobrenome">Sobrenome:</label>
                <input type="text" name="sobrenome" id="sobrenome">
                
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email">

                <input type="submit" value="Cadastrar">

            </form>
        </div>
    </main>
    <footer> 
        <div class="direitos">
            <strong>&copy;2025 CM - Camila e Maylon</strong> 
        </div>
    </footer>

    <script src="progressoScroll.js"></script>

</body>

</html>