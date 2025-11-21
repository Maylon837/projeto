<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação ESG</title>
    <link rel="stylesheet" href="../css/contato.css"> 
</head>
<body>
    
    <header class="logo">
        <a href="../index.php">
            <img src="../IMAGENS/logo-branca.png" alt="Logo CM ESG" href="#index.php">
        </a>
        <nav>
            <a href="index.php" class="home">Home</a>
            <a href="../PHP/faleconosco.html" class="contato">Fale Conosco</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="menu-perfil">
                    <button id="btn-perfil" onclick="toggleMenu()" class="home"> Conta </button>
                    <div id="menu-opcoes" class="menu-perfil-opcoes">
                        <a href="configuracao.php" class="menu-perfil-link">Configurações</a>
                        <a href="excluir_conta.php" class="menu-perfil-link" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível!');" onclick="return confirm()">Excluir conta</a>
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

        <form 
            id="avaliacaoForm" 
            action="https://submit.jotform.com/submit/253214758609665" 
            method="POST">
            <h2>Envie sua Avaliação ou Mensagem</h2>
            <p>Preencha o formulário para nos enviar sua avaliação.</p>

            <label for="email">Seu E-mail:</label>
            <input type="email" id="email" name="q59_email" required placeholder="Digite seu e-mail."> 
            
            <label for="mensagem">Sua Mensagem/Avaliação:</label>
            <textarea id="mensagem" name="q61_mensagem" rows="6" required placeholder="Deixe sua opinião ou dúvida."></textarea>

            <p id="mensagemSucesso" class="mensagem-sucesso" 
            style="
            display: none; /* Começa oculto */
            margin-top: 15px;
            margin-bottom: 5px;
            padding: 10px;
            border: 1px solid #ccffcc;
            border-radius: 4px;
            color: green;
            font-size: 20px;
            background-color: #e6ffe6;
            font-family: Oswald, 'Arial';">
            ✅ Avaliação enviada com sucesso! Obrigado.</p>
            
            <button type="submit">Enviar Avaliação</button>
        </form>

    </main>

    <footer>
        <div class="direitos">
            <strong>&copy;2025 CM - Todos os direitos reservados</strong>
        </div>
    </footer>

    <script src="../JS/progressoScroll.js"></script>
    <script src="../JS/faleconosco.js"></script>

</body>
</html>