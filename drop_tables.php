<?php
require_once("dbhost.php");

try {
    $dbname = "cabra";
    
    // Create tables
    $dbh->exec("use $dbname");

    $dbh->exec("drop table transacoes");
    $dbh->exec("drop table contas");
    $dbh->exec("drop table usuarios");
    
    echo("Tabelas excluídas");
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
