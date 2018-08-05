<?php
include("boot_guest.php");
include("header.php");
?>

<?php
require("dbhost.php");

try {
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    
    $errors = "";
    
    // check if conta exists
    $existe_sql = $dbh->prepare("select count(*) as ct from contas where dono = :uid and nome = :nome");
    $existe_sql->execute([":uid" => $_SESSION['uid'], ":nome" => $nome]);
    $existe_row = $existe_sql->fetch();
    $user_count = $existe_row['ct'];

    if ($user_count > 0) {
        $errors .= 'Conta com este nome já existe.<br>';
    }

    if ($errors == "") {
        if ($tipo == "bens" || $tipo == "despesas") {
            $sinal = 1;
        } else {
            $sinal = -1;
        }

        if (isset($_POST['orcamento'])) {
            $orcamento = $_POST['orcamento'];
        } else {
            $orcamento = 0;
        }
        
        $insert_sql = $dbh->prepare("insert into contas (dono, tipo, sinal, nome, orcamento) values (:uid, :tipo, :sinal, :nome, :orcamento)");
        $insert_sql->execute([":uid" => $_SESSION['uid'],
                              ":tipo" => $tipo,
                              ":sinal" => $sinal,
                              ":nome" => $nome,
                              ":orcamento" => $orcamento]);

        if (isset($_POST['redir'])) {
            $redirect = $_POST['redir'];
        } else {
            $redirect = "index";
        }

        if (isset($_POST['q'])) {
            $q = $_POST['q'];
        } else {
            $redirect = "";
        }

        ?>

        <h3>Conta <?= $nome ?> criada. <a href="<?= $redirect ?>.php<?= $q ?>">Voltar a <?= $redirect ?></a></h3>

    <?php
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