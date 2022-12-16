<?php 

        $semana = $_REQUEST['semana'];

        $sql = "SELECT * FROM usuarios";

        $res = $conexao->query($sql);
        // print "<pre>";
        // var_dump($row = $res->fetch_object());
        // print "</pre>";

        $sqlweek = "SELECT * FROM semana".$semana;
        $resweek = $conexao->query($sqlweek);

        if ($rowweek = $resweek->fetch_object()) {
                header("Location: ?page=relatorio&week=fail");
        } else {
                while($row = $res->fetch_object()) {
                        if ($row->conta != null) {
                                $nome = $row->nome;
                        $fcredito = (float)$row->credito;
                        $fsaldo = (float)$row->saldo_atual;
                        $fmult = (float)$row->multiplicador;
                        $bonus = (float)$row->bonus;
                        $final = (float)(($fsaldo - $fcredito - $bonus) * $fmult)*(-1);
        
                        $sqlweek = "INSERT INTO semana$semana (cliente, saldo, checked) VALUES ('{$nome}', '{$final}', '1')";
                        $resweek = $conexao->query($sqlweek);
                        }
                }
                header("Location: ?page=relatorio&week=success");
        }
        
        