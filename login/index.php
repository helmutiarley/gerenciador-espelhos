<?php
include_once('../src/config/config.php');
    session_start();
    if(isset($_SESSION["id"])) {
        header("Location: ../");
    } else if(isset($_POST['email']) || isset($_POST['senha'])) {
        if (strlen($_POST['email']) == 0 ) {
            echo "Preencha seu e-mail!"; 
        } else if (strlen($_POST['senha']) == 0) {
            echo "Preencha sua senha!";
        } else {
            $email = $conexao->real_escape_string($_POST['email']);
            $senha = $conexao->real_escape_string($_POST['senha']);

            $sql_code = "SELECT * FROM adm WHERE email = '$email' AND senha = '$senha'";
            $sql_query = $conexao->query($sql_code) or die("Falha na execução do código SQL: ". $conexao->error);

            $quantidade = $sql_query->num_rows;

            if ($quantidade == 1) {
                
                $usuario = $sql_query->fetch_assoc();

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];
                header("Location: ../");
                
            } else {
                echo "Falha ao logar. E-mail ou senha incorretos.";
            }


        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/painel.css">
    <script src="../source/js/bootstrap.min.js"></script>
    <title>Painel de Controle</title>
</head>
<body>
    <div class="shadow p-3 mb-5 bg-white rounded w-75 p-3" style="margin-top: 100px;">
        <form action="" method="POST">
            <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">E-mail</span>
                <input type="email" name="email" placeholder="Digite seu e-mail..." class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
            </div>

            <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Senha</span>
                <input type="password" name="senha" placeholder="Digite sua senha..." class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
            </div>
            <div style="display:flex; justify-content: flex-end;"><button type="submit" class="btn btn-primary btn-sm">Entrar</button></div>
        </form>
    </div>
</body>
</html>