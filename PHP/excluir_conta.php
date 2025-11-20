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
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; 
            margin: 0;
            background-color: #f8f9fa; 
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: white;
            padding: 40px;
            border: 1px solid #ccc; 
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center; 
            max-width: 400px;
            width: 90%;
        }

        h1 {
            color: #28a745; 
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .btn-principal {
            /* Estilo do botão */
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .btn-principal:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <main>
        <div class="container">
            <h1>Cadastro Excluído com sucesso</h1>
            
            <a href="index.php" class="btn-principal">
                Voltar para a Página Principal
            </a>
        </div>
    </main>

</body>
</html>