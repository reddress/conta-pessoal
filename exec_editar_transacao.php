<?php
include("boot_guest.php");
include("header.php");
require("dbhost.php");

try {
    $tr_id = $_POST['tr_id'];
    
    $cr_id = $_POST['cr'];
    $dr_id = $_POST['dr'];
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $data_dmy = $_POST['data'];
    $redir = $_POST['redir'];
    
    $errors = "";
    
    if (trim($nome) == "") {
        $errors .= 'Nome não deve estar em branco.<br>';
    }

    if (trim($valor) == "") {
        $errors .= 'Valor não deve estar em branco. <a href="javascript: history.back()">Tente novamente.</a>';
    }

    if ((int) $cr_id == -1) {
        $errors .= 'Escolha uma conta "De conta"';
    }
    
    if ((int) $dr_id == -1) {
        $errors .= 'Escolha uma conta "Para conta"';
    }
    
    if ($errors == "") {
        $date_obj = date_create_from_format("d/m/Y", $data_dmy);
        $data = date_format($date_obj, "Y-m-d");

        $update_sql = $dbh->prepare("update transacoes set data = :data, nome = :nome, valor = :valor, dr = :dr_id, cr = :cr_id where dono = :uid and id = :tr_id");
        $update_sql->execute([":data" => $data,
                              ":nome" => $nome,
                              ":valor" => $valor,
                              ":dr_id" => $dr_id,
                              ":cr_id" => $cr_id,
                              ":uid" => $_SESSION['uid'],
                              ":tr_id" => $tr_id]);
    } else {
        exit('<br><a href="javascript: history.back()">Tente novamente.</a>');
    }
?>

Transação atualizada. <a href="<?= $redir ?>">Voltar a página anterior</a>

<?php
// header("Location: tipo_de_conta.php?t={$tipo}");
?>

<?php 
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<?php
include("footer.php");
?>
