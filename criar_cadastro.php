<?php
include("header.php");
?>

<?php
require("dbhost.php");
require("login_util.php");

try {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $senha_repetir = $_POST['senha_repetir'];

    $errors = "";
    
    if ($senha != $senha_repetir) {
        $errors .= 'As senhas não coincidem.<br>';
    }

    // check if username exists
    $existe_sql = $dbh->prepare("select count(*) as ct from usuarios where nome = :nome");
    $existe_sql->execute([":nome" => $nome]);
    $existe_row = $existe_sql->fetch();
    $user_count = $existe_row['ct'];

    if ($user_count > 0) {
        $errors .= 'Nome de usuário não disponível.<br>';
    }

    if ($errors == "") {
        $insert_sql = $dbh->prepare("insert into usuarios (nome, hash) values (:nome, :hash)");
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $insert_sql->execute([":nome" => $nome, ":hash" => $hash]);

        echo('Usuário criado. <a href="login.php">Fazer login</a>');

        $lookup_sql = $dbh->prepare("select id, nome, hash from usuarios where nome = :nome");
        $lookup_sql->execute([":nome" => $nome]);
        $usuario_row = $lookup_sql->fetch();
        save_cookie($dbh, $usuario_row['id']);

        header('Location: index.php');
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
