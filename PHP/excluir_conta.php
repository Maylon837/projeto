<?php
session_start();
include "conexao.php";

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $sql = "DELETE FROM cadastros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        session_unset();
        session_destroy();
        
    } else {
        echo "Erro ao excluir conta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Erro: Usuário não logado.";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusão Concluída</title>
    <link rel="stylesheet" href="../css/excluirconta.css">
    
</head>
<body>

    <main>
        <div class="container">
            <h1>Conta Excluída com Sucesso</h1>
            <p>Sua conta foi excluída.</p>
            
            <a href="index.php" class="btn-principal">
                Voltar para a Página Principal
            </a>
        </div>
    </main>

</body>
</html>