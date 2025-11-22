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
    $usuario_atual = ['nome' => 'N/A', 'sobrenome' => 'N/A', 'email' => 'N/A', 'newsletter_ativo' => 0];
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
    <link rel="stylesheet" href="../css/home.css"> 
    <link rel="stylesheet" href="../css/cabecalho.css">
    <style>
        .bloco-mensagem {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    
    <header class="logo">
        <a href="../index.php">
            <img src="../IMAGENS/logo-branca.png" alt="Logo CM ESG" href="#index.php">
        </a>
        <nav>
            <a href="../PHP/index.php" class="home">Home</a>
            <a href="../PHP/faleconosco.php" class="contato">Fale Conosco</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="menu-perfil">
                    <button id="btn-perfil" onclick="toggleMenu()" class="home">Conta</button>
                    <div id="menu-opcoes" class="menu-perfil-opcoes">
                        <a href="configuracao.php" class="menu-perfil-link">Configurações</a> 
                        <a href="excluir_conta.php" class="menu-perfil-link" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível!');">Excluir conta</a>
                        <a href="logout.php" class="menu-perfil-link">Sair</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="cadastro.php" class="btn-cadastro">Cadastro</a>
                <a href="login.php" class="btn-login">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <main style="display: flex; justify-content: center; align-items: center; min-height: 70vh; padding: 20px 0;">
        
        <div id="bloco-configuracoes" style="text-align: center; padding: 30px; border: 1px solid #ccc; max-width: 600px; width: 90%; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <br>
            <br>
            <br>
            <br>
            <h2>⚙️ Configurações da Conta</h2>
            
            <?php echo $mensagem_status; ?>
            
            
            
            <form action="configuracao.php" method="POST" style="text-align: left; margin-top: 20px;">
                <input type="hidden" name="atualizar_dados" value="1">
                
                <label for="nome">Nome Atual:</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($usuario_atual['nome']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
                
                <label for="sobrenome">Sobrenome Atual:</label>
                <input type="text" name="sobrenome" id="sobrenome" value="<?php echo htmlspecialchars($usuario_atual['sobrenome']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">
                
                <input type="submit" value="Atualizar Dados" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            </form>
            
            
            
            <form action="configuracao.php" method="POST" style="text-align: left; margin-top: 30px;">
                <input type="hidden" name="atualizar_senha" value="1">
                
                <label for="senha">Nova Senha:</label>
                <input type="password" name="senha" id="senha" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">
                
                <label for="confirmar_senha">Confirmar Nova Senha:</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px;">
                
                <input type="submit" value="Atualizar Senha" style="width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
            </form>
            
            
            
            
            
            <div style="margin-top: 20px; text-align: left; padding: 15px; border: 1px dashed #aaa; border-radius: 5px;">
                <p><strong>Outras Opções:</strong></p>
                <label><input type="checkbox" name="modo_escuro"> Ativar modo escuro (Em Breve)</label>
            </div>
            
        </div>
        
    </main>
    
    <footer>
        <div class="direitos">
            <strong>&copy; 2025 CM - Todos os direitos reservados</strong>
        </div>
    </footer>
    </body>
</html>