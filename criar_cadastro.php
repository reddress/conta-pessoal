<?php
include("header.php");
?>

<?php
require("dbhost.php");
require("login_util.php");
require("contas_util.php");

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
        $uid = $usuario_row['id'];
        save_cookie($dbh, $uid);

        // criar contas padroes
        insert_conta($dbh, $uid, "bens", 1, "Outros bens", 0);
        insert_conta($dbh, $uid, "despesas", 1, "Outras despesas", 0);
        insert_conta($dbh, $uid, "receitas", -1, "Outras receitas", 0);
        insert_conta($dbh, $uid, "credito", -1, "Empréstimos em dinheiro", 0);
        insert_conta($dbh, $uid, "ajustes", -1, "Ajuste de bens", 0);
        insert_conta($dbh, $uid, "ajustes", -1, "Ajuste de cartões", 0);
        insert_conta($dbh, $uid, "ajustes", -1, "Outros ajustes", 0);
        insert_conta($dbh, $uid, "ajustes", -1, "Contas apagadas", 0);        

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
