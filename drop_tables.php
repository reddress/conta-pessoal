<?php
require_once("dbhost.php");

try {
    $dbname = "cabra";
    
    // Create tables
    $dbh->exec("use $dbname");

    $dbh->exec("drop table autologin");
    $dbh->exec("drop table transacoes");
    $dbh->exec("drop table contas");
    $dbh->exec("drop table usuarios");
    
    echo("Tabelas excluídas");
    echo('<br><br><a href="install.php">Re-instalar</a>');
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
