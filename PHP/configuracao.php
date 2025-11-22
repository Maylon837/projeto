<?php
session_start();
include("conexao.php"); 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit();
}

$userId = $_SESSION['user_id'];
$mensagem_status = "";

try {
    $sql_busca = "SELECT nome, sobrenome, email, newsletter_ativo FROM cadastros WHERE id = ?";
    $stmt_busca = $conn->prepare($sql_busca);
    $stmt_busca->bind_param("i", $userId);
    $stmt_busca->execute();
    $resultado = $stmt_busca->get_result();
    $usuario_atual = $resultado->fetch_assoc();
    $stmt_busca->close();

} catch (Exception $e) {
    $mensagem_status = "<div class='bloco-mensagem erro'>Erro ao buscar dados: " . $e->getMessage() . "</div>";
    $usuario_atual = ['nome' => '', 'sobrenome' => '', 'email' => '', 'newsletter_ativo' => 0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar_dados'])) {
    $novo_nome = trim($_POST['nome']);
    $novo_sobrenome = trim($_POST['sobrenome']);
    
    if (!empty($novo_nome) && !empty($novo_sobrenome)) {
        
        $sql_update_dados = "UPDATE cadastros SET nome = ?, sobrenome = ? WHERE id = ?";
        
        if (!$stmt_update = $conn->prepare($sql_update_dados)) {
            $mensagem_status = "<div class='bloco-mensagem erro'>Erro de preparação SQL (Nome/Sobrenome): " . $conn->error . "</div>";
        } else {
            $stmt_update->bind_param("ssi", $novo_nome, $novo_sobrenome, $userId);
            
            if ($stmt_update->execute()) {
                $mensagem_status = "<div class='bloco-mensagem sucesso'>Nome e Sobrenome atualizados com sucesso!</div>";
                $usuario_atual['nome'] = $novo_nome;
                $usuario_atual['sobrenome'] = $novo_sobrenome;
            } else {
                $mensagem_status = "<div class='bloco-mensagem erro'>Erro ao atualizar dados: " . $stmt_update->error . "</div>";
            }
            $stmt_update->close();
        }
    } else {
         $mensagem_status = "<div class='bloco-mensagem erro'>Nome e Sobrenome não podem estar vazios.</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar_senha'])) {
    $nova_senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    
    if (empty($nova_senha) || empty($confirmar_senha)) {
        $mensagem_status = "<div class='bloco-mensagem erro'>Por favor, preencha a nova senha e a confirmação.</div>";
    } elseif ($nova_senha !== $confirmar_senha) {
        $mensagem_status = "<div class='bloco-mensagem erro'>A nova senha e a confirmação não coincidem.</div>";
    } elseif (strlen($nova_senha) < 6) { 
        $mensagem_status = "<div class='bloco-mensagem erro'>A senha deve ter pelo menos 6 caracteres.</div>";
    } else {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $sql_update_senha = "UPDATE cadastros SET senha = ? WHERE id = ?";
        
        if (!$stmt_senha = $conn->prepare($sql_update_senha)) {
            $mensagem_status = "<div class='bloco-mensagem erro'>Erro de preparação SQL (Senha): " . $conn->error . "</div>";
        } else {
            $stmt_senha->bind_param("si", $senha_hash, $userId);
            
            if ($stmt_senha->execute()) {
                $mensagem_status = "<div class='bloco-mensagem sucesso'>Senha atualizada com sucesso!</div>";
            } else {
                $mensagem_status = "<div class='bloco-mensagem erro'>Erro ao atualizar senha: " . $stmt_senha->error . "</div>";
            }
            $stmt_senha->close();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toggle_newsletter'])) {
    $status_anterior = (int)$_POST['status_atual'];
    $novo_status = $status_anterior == 1 ? 0 : 1;
    
    $sql_update_newsletter = "UPDATE cadastros SET newsletter_ativo = ? WHERE id = ?";
    
    if (!$stmt_newsletter = $conn->prepare($sql_update_newsletter)) {
        $mensagem_status = "<div class='bloco-mensagem erro'>Erro de preparação SQL (Newsletter): " . $conn->error . "</div>";
    } else {
        $stmt_newsletter->bind_param("ii", $novo_status, $userId);
        
        if ($stmt_newsletter->execute()) {
            if ($novo_status == 1) {
                $mensagem_status = "<div class='bloco-mensagem sucesso'>Newsletter ativada! Você receberá atualizações.</div>";
            } else {
                $mensagem_status = "<div class='bloco-mensagem sucesso'>Newsletter desativada.</div>";
            }
            $usuario_atual['newsletter_ativo'] = $novo_status; // Atualiza para o HTML
        } else {
            $mensagem_status = "<div class='bloco-mensagem erro'>Erro ao atualizar Newsletter: " . $stmt_newsletter->error . "</div>";
        }
        $stmt_newsletter->close();
    }
}

if (isset($conn)) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Configurações da Conta</title>
    <link rel="stylesheet" href="../css/config.css">
    <link rel="stylesheet" href="../css/cabecalho.css">

    <script>
        (function(w,d,e,u,f,l,n){w[f]=w[f]||function(){(w[f].q=w[f].q||[])
            .push(arguments);},l=d.createElement(e),l.async=1,l.src=u,
            n=d.getElementsByTagName(e)[0],n.parentNode.insertBefore(l,n);})
            (window,document,'script','https://assets.mailerlite.com/js/universal.js','ml');
            ml('account', '1936898');

    </script>
    
</head>
<body>
    
    <header class="logo">
        <a href="../PHP/index.php">
            <img src="../IMAGENS/logo-branca.png" alt="Logo CM ESG" href="#index.php">
        </a>
        <nav>
            <a href="../PHP/index.php" class="home">Home</a>
            <a href="../PHP/faleconosco.php" class="contato">Fale Conosco</a>
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
        
            
        <div id="bloco-configuracoes">
            

            <h2>⚙️Configurações da Conta</h2>
            
            <?php echo $mensagem_status; ?>
            
            <div class="newsletter">
                <div class="ml-embedded" data-form="ekd6Mo"></div>
            </div>
            </form>
            <form action="configuracao.php" method="POST" id="form-nome">
                <h3>📝Atualizar dados</h3>
                <input type="hidden" name="atualizar_dados" value="1">
                
                <label for="nome"><strong>Novo Nome:</strong></label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($usuario_atual['nome']); ?>" required placeholder= "Digite o novo nome" >
                
                <label for="sobrenome"><strong>Novo Sobrenome:</strong></label>
                <input type="text" name="sobrenome" id="sobrenome" value="<?php echo htmlspecialchars($usuario_atual['sobrenome']); ?>" required placeholder="Digite o novo sobrenome">
                
                <input type="submit" value="Atualizar Dados" class="input-nome" >
            </form>
              
            
            <form action="configuracao.php" method="POST" id="form-senha">
                <h3>🔒Atualizar senha</h3>
                <input type="hidden" name="atualizar_senha" value="1">
                
                <label for="senha"><strong>Nova Senha:</strong></label>
                <input type="password" name="senha" id="senha" required placeholder="Digite a nova senha">
                
                <label for="confirmar_senha"><strong>Confirmar Nova Senha:</strong></label>
                <input type="password" name="confirmar_senha" id="confirmar-senha" required placeholder="Digite a nova senha novamente">
                
                <input type="submit" value="Atualizar Senha" class="input-senha" >
            </form>
            

            <div class="modo-escuro">
                <p class="acessibilidade"><strong>Acessibilidade</strong></p>
                <p><strong>Modo escuro</strong></p>
                <label><input type="checkbox" name="modo_escuro"> Ativar modo escuro (Em Breve)</label>
            </div>
            
        </div>
        
    </main>
    
    <footer>
        <div class="direitos">
            <strong>&copy; 2025 CM - Todos os direitos reservados</strong>
        </div>
    </footer>
    <script src="newsletter.js"></script>
    </body>
</html>