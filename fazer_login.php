<?php
include("header.php");
?>

<?php
require("dbhost.php");

$nome = $_POST['nome'];
$senha = $_POST['senha'];

$lookup_sql = $dbh->prepare("select nome, hash from usuarios where nome = :nome");
$lookup_sql->execute([":nome" => $nome]);
$usuario_row = $lookup_sql->fetch();

if (!$usuario_row || !password_verify($senha, $usuario_row['hash'])) {
    echo('Usuário não existe ou senha incorreta. <br><a href="javascript: history.back()">Tente novamente.</a>');
} else {
    echo("FAZER LOGIN");
    
}
?>

<?php
include("footer.php");
?>
