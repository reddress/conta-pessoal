<?php
include("boot_guest.php");
include("header.php");
require("transacoes_util.php");

try {
    $tr_id = $_POST['tr_id'];
    $redir = $_POST['redir'];
    
    $lookup_sql = $dbh->prepare("select nome from transacoes where dono = :uid and id = :tr_id");
    $lookup_sql->execute([":uid" => $_SESSION['uid'],
                          ":tr_id" => $tr_id]);
    $tr_row = $lookup_sql->fetch();
    $tr_nome = $tr_row['nome'];
    
    delete_transacao($dbh, $_SESSION['uid'], $tr_id);
    echo("Transação $tr_nome excluída. ");
    ?>
    
    <a href="<?= $redir ?>">Voltar a página anterior.</a>

    <?php
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<?php
include("footer.php");
?>
