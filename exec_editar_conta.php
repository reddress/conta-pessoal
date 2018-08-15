<?php
include("boot_guest.php");
include("header.php");
require("dbhost.php");

try {
    $conta_id = $_POST['conta_id'];
    $tipo = $_POST['tipo'];
    $nome = $_POST['nome'];

    if (isset($_POST['orcamento'])) {
        $orcamento = $_POST['orcamento'];
        if ($orcamento == "") {
            $orcamento = 0;
        }
    } else {
        $orcamento = 0;
    }

    $errors = "";
    
    if (trim($nome) == "") {
        exit('Nome não deve estar em branco. <a href="javascript: history.back()">Tente novamente.</a>');
    }

    if ($tipo == "bens" || $tipo == "despesas") {
        $sinal = 1;
    } else {
        $sinal = -1;
    }
    
    $update_sql = $dbh->prepare("update contas set tipo = :tipo, sinal = :sinal, nome = :nome, orcamento = :orcamento where dono = :uid and id = :conta_id");
    $update_sql->execute([":tipo" => $tipo,
                          ":sinal" => $sinal,
                          ":nome" => $nome,
                          ":orcamento"=> $orcamento,
                          ":uid" => $_SESSION['uid'],
                          ":conta_id" => $conta_id]);
?>

Conta atualizada. <a href="tipo_de_conta.php?t=<?= $tipo ?>">Voltar a tipo de conta <?= $tipo ?></a>

<?php
header("Location: tipo_de_conta.php?t={$tipo}");
?>

<?php 
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<?php
include("footer.php");
?>
