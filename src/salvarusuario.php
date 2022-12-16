<?php
    switch ($_REQUEST["acao"]) {
        case "cadastrar";
            $nome = $_POST["nome"];
            $credito = $_POST["credito"];
            $saldo = $_POST["saldo"];
            $multiplicador = $_POST["multiplicador"];

            $sql = "INSERT INTO usuarios (nome, credito, saldo_atual, multiplicador) VALUES ('{$nome}', '{$credito}', '{$saldo}', '{$multiplicador}')";
            
            $res = $conexao->query($sql);

            if ($res == true) {
                print "<script>alert('Cadastrado com sucesso!');</script>";
                print "<script>location.href = '?page=usuarios';</script>";
            } else {
                print "<script>alert('Não foi possível cadastrar...');</script>";
                print "<script>location.href = '?page=usuarios';</script>";
            }
            break;
        case "editar";

            $nome_conta = $_POST["conta"];
            $nome = $_POST["nome"];
            $id_cliente = $_POST["id"];
            $multiplicador = $_POST["multiplicador"];
            $credito = str_replace(',', '.', $_POST["credito"]);
            $credito = (float)$credito;
            $saldoatual = str_replace(',', '.', $_POST["saldoatual"]);
            $saldoatual = (float)$saldoatual;
            $bonus = str_replace(',', '.', $_POST["bonus"]);
            $bonus = (float)$bonus;
            $senhaconta = $_POST["senhaconta"];
            $obs = $_POST["obs"];

            // VERIFICAR SE EXISTE CONTA PARA ALTERAR SENHA

                if ($nome_conta == null) {
                    return;
                } else {
                    $sqlsenha = "UPDATE contas SET senha_conta='{$senhaconta}' WHERE login_conta='$nome_conta'";
                    $ressenha = $conexao->query($sqlsenha);
                }

                

            if ($nome_conta == 'semconta') {
                $sql = "UPDATE usuarios SET nome='{$nome}', credito='{$credito}', saldo_atual='{$saldoatual}', last_update=(now()), conta='', bonus='{$bonus}', obs='{$obs}', multiplicador='{$multiplicador}' WHERE id=$id_cliente";
            } else {
                $sql = "UPDATE usuarios SET nome='{$nome}', credito='{$credito}', saldo_atual='{$saldoatual}', last_update=(now()), conta='{$nome_conta}', bonus='{$bonus}', obs='{$obs}', multiplicador='{$multiplicador}', usertoupdate='{$_SESSION['nome']}' WHERE id=$id_cliente";
            }

            // VERIFICAR SE JÁ EXISTE UM USUÁRIO COM ESSE NOME CADASTRADO

            $sql_change_verify = "SELECT nome FROM usuarios WHERE id=". $id_cliente;
            $res_change_verify = $conexao->query($sql_change_verify);
            $row_change_verify = $res_change_verify->fetch_object();
            
            if ($row_change_verify->nome != $nome) {
                $sql_verify_nome = "SELECT nome FROM usuarios WHERE nome='$nome'";
                $res_verify_nome = $conexao->query($sql_verify_nome);
                $row_verify_nome = $res_verify_nome->fetch_object();
    
                if ($res_verify_nome->num_rows > 0) {
                    print "<script>location.href = '?page=usuarios&success=userexists';</script>";
                    die();
                }
            }

            

            // VERIFICAR SE O USUARIO ESTA ATRELADO A ALGUMA CONTA
            $sql_verify = "SELECT conta FROM usuarios WHERE conta='$nome_conta'";

            $res_verify = $conexao->query($sql_verify);

            $qtd_verify = $res_verify->num_rows;

            if ($qtd_verify > 0) {
                $sql_verify = "UPDATE usuarios SET conta='' WHERE conta='$nome_conta'";
                $res = $conexao->query($sql_verify);
            }

            $res = $conexao->query($sql);

            if ($res == true) {
                print "<script>location.href = '?page=usuarios&success=edited';</script>";
            } else {
                print "<script>alert('Não foi possível cadastrar...');</script>";
                print "<script>location.href = '?page=usuariossuccess=failed';</script>";
            }
            break;
        case "editarsemana";
            $id = $_POST['id'];
            $semana = $_POST['semana'];
            $cliente = $_POST['nome'];
            $saldo = $_POST['saldofinal'];
            $saldoformatado = (float)str_replace(',', '.', $saldo);
            $sql_verify = "UPDATE semana$semana SET cliente='$cliente', saldo='$saldoformatado' WHERE id='$id'";
            $res = $conexao->query($sql_verify);
            if ($res == true) {
                print "<script>alert('Editado com sucesso!');</script>";
                print "<script>location.href = '?page=archive';</script>";
            } else {
                print "<script>alert('Não foi possível editar...');</script>";
                print "<script>location.href = '?page=archive';</script>";
            }
            break;
        case "excluir";
             
            $sql = "DELETE FROM usuarios WHERE id=". $_REQUEST["id"];

            $res = $conexao->query($sql);

            if ($res == true) {
                print "<script>alert('Excluido com sucesso!');</script>";
                print "<script>location.href = '?page=usuarios';</script>";
            } else {
                print "<script>alert('Não foi possível excluir...');</script>";
                print "<script>location.href = '?page=usuarios';</script>";
            }

            break;
        case "excluirconta";
            $sql = "UPDATE usuarios SET conta='' WHERE id=". $_REQUEST["id"];

            $res = $conexao->query($sql);

            if ($res == true) {
                print "<script>alert('Conta excluida com sucesso!');</script>";
                print "<script>location.href = '?page=usuarios';</script>";
            } else {
                print "<script>alert('Não foi possível excluir a conta...');</script>";
                print "<script>location.href = '?page=usuarios';</script>";
            }
        break;
    }


?>