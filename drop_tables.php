<?php
require_once("dbhost.php");

$debug = true;

try {
    if ($debug) {
        $dbname = "cabra";
    
        $dbh->exec("use $dbname");

        $dbh->exec("drop table autologin");
        $dbh->exec("drop table transacoes");
        $dbh->exec("drop table contas");
        $dbh->exec("drop table usuarios");
    
        echo("Tabelas excluídas");
        echo('<br><br><a href="install.php">Re-instalar</a>');
    } else {
        echo('Entre no modo Debug editando o código-fonte para excluir as tabelas.');
    }
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
