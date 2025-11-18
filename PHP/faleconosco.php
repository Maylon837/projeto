<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre os Desenvolvedores</title>
    <link rel="stylesheet" href="../css/cabecalho.css">
    <link rel="stylesheet" href="../css/contato.css">
    
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
            <a href="#" class="contato">Fale Conosco</a>
            <a href="./cadastro.php" class="btn-cadastro">Cadastro</a>
            <a href="./login.php" class="btn-login">Login</a>
        </nav>
    </header>

    <main>
        <h2>Envie sua Avaliação ou Mensagem (Privilégio Ativo)</h2>

        <p>Seu e-mail será anexado automaticamente para rastreamento da avaliação.</p>

        <form action="https://docs.google.com/forms/d/e/1FAIpQLScoefNR8gAcCHS0MZ6TVOBTukzbPoAOjpjXB4gHWhwiasM_Kw/viewform?embedded=true" method="POST">
            
            <label style="font-weight: bold;">Seu E-mail (Automático):</label>
            <input type="email" name="_replyto" 
                   value="<?php echo htmlspecialchars($user_email); ?>" 
                   required readonly> 
            <small style="display: block; margin-bottom: 20px;">Você está enviando como: <?php echo htmlspecialchars($user_email); ?></small>

            <label for="mensagem" style="display: block; margin-bottom: 5px; font-weight: bold;">
                Sua Mensagem/Avaliação:
            </label>
            <textarea id="mensagem" name="Avaliacao" rows="8" required 
                      placeholder="Deixe aqui sua opinião ou dúvida sobre o conteúdo ESG do nosso site."></textarea>
            
            <input type="text" name="_gotcha" style="display: none;">

            <button type="submit" style="margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: white; border: none; cursor: pointer;">
                Enviar Avaliação
            </button>

        </form>
    </main>

    <footer> 
        <div class="direitos">
            <strong>&copy;2025 CM - Camila e Maylon</strong> 
        </div>
    </footer>

    <script src="../JS/progressoScroll.js"></script>
</body>
</html>