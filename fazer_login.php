<?php
include("header.php");
?>

<?php
require("dbhost.php");
require("login_util.php");

$nome = $_POST['nome'];
$senha = $_POST['senha'];

$lookup_sql = $dbh->prepare("select id, nome, hash from usuarios where nome = :nome");
$lookup_sql->execute([":nome" => $nome]);
$usuario_row = $lookup_sql->fetch();

if (!$usuario_row || !password_verify($senha, $usuario_row['hash'])) {
    echo('Usuário não existe ou senha incorreta. <br><a href="javascript: history.back()">Tente novamente.</a>');
} else {
    save_cookie($dbh, $usuario_row['id']);
    echo("Usuário {$usuario_row['nome']} logado.");
    echo('<hr><a href="index.php">Voltar a homepage</a>');
    header('Location: index.php');
}
?>

<?php
include("footer.php");
?>
