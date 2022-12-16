<?php
    switch ($_REQUEST["acao"]) {
        case "cadastrar";
            $login = $_POST["login"];
            $senha = $_POST["senha"];

            $sql = "INSERT INTO contas (login_conta, senha_conta) VALUES ('{$login}', '{$senha}')";
            
            $res = $conexao->query($sql);

            if ($res == true) {
                print "<script>alert('Cadastrado com sucesso!');</script>";
                print "<script>location.href = '?page=contas';</script>";
            } else {
                print "<script>alert('Não foi possível cadastrar...');</script>";
                print "<script>location.href = '?page=contas';</script>";
            }
            break;
        case "editar";
            $login = $_POST["login"];
            $senha = $_POST["senha"];

            $sql = "UPDATE contas SET login_conta='{$login}', senha_conta='{$senha}' WHERE id_conta=". $_REQUEST["id"];

            $res = $conexao->query($sql);

            if ($res == true) {
                print "<script>alert('Editado com sucesso!');</script>";
                print "<script>location.href = '?page=contas';</script>";
            } else {
                print "<script>alert('Não foi possível cadastrar...');</script>";
                print "<script>location.href = '?page=contas';</script>";
            }
            break;
        case "excluir";
             
            $sql = "DELETE FROM contas WHERE id_conta=". $_REQUEST["id"];

            $res = $conexao->query($sql);

            if ($res == true) {
                print "<script>alert('Excluido com sucesso!');</script>";
                print "<script>location.href = '?page=contas';</script>";
            } else {
                print "<script>alert('Não foi possível excluir...');</script>";
                print "<script>location.href = '?page=contas';</script>";
            }

            break;
    }


?>