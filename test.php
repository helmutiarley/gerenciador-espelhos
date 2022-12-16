<?php
    include('../espelhos_novo/src/config/config.php');
    $i = 45;
    while ($i <= 52) {
        $sql = "CREATE TABLE `tabela$i` ( `id` INT NOT NULL AUTO_INCREMENT , `cliente` VARCHAR NOT NULL , `saldo` DOUBLE NOT NULL , `checked` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $res = $conexao->query($sql);
        $i++;
    }

?>