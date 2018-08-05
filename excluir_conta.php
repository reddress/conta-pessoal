<?php
include("boot_guest.php");
include("header.php");
require("contas_util.php");

try {
    $conta_id = $_POST['conta_id'];

    $lookup_sql = $dbh->prepare("select nome from contas where dono = :uid and id = :conta_id");
    $lookup_sql->execute([":uid" => $_SESSION['uid'],
                          ":conta_id" => $conta_id]);
    $conta_row = $lookup_sql->fetch();
    $conta_nome = $conta_row['nome'];
    
    delete_conta($dbh, $_SESSION['uid'], $conta_id);
    echo("Conta $conta_nome excluída. ");
    echo('<a href="conta.php">Todas as contas.</a>');
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<?php
include("footer.php");
?>
