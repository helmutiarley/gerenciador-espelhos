<?php
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', '');
    define('DB', 'espelho');

    $conexao = new mysqli(HOST, USER, PASS, DB);
    $i = 45;
    while ($i <= 52) {
        $sql = "CREATE TABLE `tabela$i` ( `id` INT NOT NULL AUTO_INCREMENT , `cliente` VARCHAR NOT NULL , `saldo` DOUBLE NOT NULL , `checked` INT NOT NULL , PRIMARY KEY (`id`))";
        $res = $conexao->query($sql);
        $i++;
    }

?>