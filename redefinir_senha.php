<?php
include("header.php");
?>

<?php
require("login_util.php");

try {
    $nome = $_POST['nome'];
    $senha_atual = $_POST['senha_atual'];
    $senha = $_POST['senha'];
    $senha_repetir = $_POST['senha_repetir'];
    
    $errors = "";

    $lookup_sql = $dbh->prepare("select hash from usuarios where nome = :nome");
    $lookup_sql->execute([":nome" => $nome]);
    $usuario_row = $lookup_sql->fetch();

    if (!password_verify($senha_atual, $usuario_row['hash'])) {
        $errors .= 'Senha atual incorreta. <br>';
    }

    if ($senha != $senha_repetir) {
        $errors .= 'As senhas novas não coincidem.<br>';
    }

    if ($errors == "") {
        $update_sql = $dbh->prepare("update usuarios set hash = :hash where nome = :nome");
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $update_sql->execute([":nome" => $nome, ":hash" => $hash]);

        echo('Senha atualizada. <a href="index.php">Voltar a homepage</a>');
    } else {
        echo($errors);
        echo('<br><a href="javascript: history.back()">Tente novamente.</a>');
    }
        
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<?php
include("footer.php");
?>
