<?php
include("boot_guest.php");
include("header.php");
require("dbhost.php");

try {
    $tr_id = $_GET['id'];
    $redir = $_GET['redir'];
    
    // check if transacao exists
    $existe_sql = $dbh->prepare("select nome from transacoes where dono = :uid and id = :tr_id");
    $existe_sql->execute([":uid" => $_SESSION['uid'], ":tr_id" => $tr_id]);
    $existe_row = $existe_sql->fetch();
    $tr_nome = $existe_row['nome'];
?>

    <h1>Confirmar excluir transação <?= $tr_nome ?>?</h1>

    <form action="excluir_transacao.php" method="POST">
        <input name="tr_id" value="<?= $tr_id ?>" type="hidden">
        <input name="redir" value="<?= $redir ?>" type="hidden">
        <input type="submit" value="Sim, excluir">
    </form>

    <br><br>

    <h3><a href="<?= $redir ?>">Não, voltar</a></h3>
    
<?php        
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<?php
include("footer.php");
?>
