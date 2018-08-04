<?php
include("header.php");
?>

<?php
require("login_util.php");

// Log out
session_unset();

if (isset($_COOKIE['autologin'])) {
    delete_cookie($dbh, $_COOKIE['autologin']);
}

try {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $senha_repetir = $_POST['senha_repetir'];
    $senha_superuser = $_POST['senha_superuser'];
    
    $errors = "";
    
    if ($senha != $senha_repetir) {
        $errors .= 'As senhas não coincidem.<br>';
    }

    // check if username exists
    $existe_sql = $dbh->prepare("select count(*) as ct from usuarios where nome = :nome");
    $existe_sql->execute([":nome" => $nome]);
    $existe_row = $existe_sql->fetch();
    $user_count = $existe_row['ct'];

    if ($user_count == 0) {
        $errors .= 'Nome de usuário não encontrado.<br>';
    }

    if ($senha_superuser != $senha_superuser_default) {
        $errors .= 'Senha de Superuser incorreta.<br>';
    }

    if ($errors == "") {
        $update_sql = $dbh->prepare("update usuarios set hash = :hash where nome = :nome");
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $update_sql->execute([":nome" => $nome, ":hash" => $hash]);

        echo('Senha atualizada. <a href="login.php">Fazer login</a>');
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
