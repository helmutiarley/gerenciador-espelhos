<?php

    function get_inicio_fim_semana($numero_semana = "", $ano = "") {

    $semana_atual = strtotime('+'.$numero_semana.' weeks', strtotime($ano.'0101'));

    $dia_semana = date('w', $semana_atual);

    $data_inicio_semana = strtotime('-'.$dia_semana.' days', $semana_atual);

    /* Data início semana */
    $primeiro_dia_semana = date('d-m-Y', $data_inicio_semana);

    /* Soma 6 dias */
    $ultimo_dia_semana = date(
        'd-m-Y',
        strtotime('+6 days', strtotime($primeiro_dia_semana))
    );

    /* retorna */
    return array($primeiro_dia_semana, $ultimo_dia_semana);
    }

    $i = 1;
    
    $semanas = [];

    while ($i <= 52) {

    $res = get_inicio_fim_semana($i, 2022);

    // $sql = "DROP TABLE semana$i";
    // $sql = "CREATE TABLE `espelho`.`semana" . $i . "` (`cliente` VARCHAR(150) NOT NULL , `saldo` DOUBLE NOT NULL, `checked` INT NOT NULL ) ENGINE = InnoDB;";
    // $res = $conexao->query($sql);

    $semanas[] = $res;



    $i++;
    }
?>
