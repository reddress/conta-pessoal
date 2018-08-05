<?php
include("boot_guest.php");
include("header.php");
require("dbhost.php");

try {
    $conta_id = $_GET['id'];

    // check if conta exists
    $existe_sql = $dbh->prepare("select nome from contas where dono = :uid and id = :conta_id");
    $existe_sql->execute([":uid" => $_SESSION['uid'], ":conta_id" => $conta_id]);
    $existe_row = $existe_sql->fetch();
    $conta_nome = $existe_row['nome'];
?>

    <h1>Realmente excluir conta <?= $conta_nome ?></h1>

    <form action="excluir_conta.php" method="POST">
        <input name="conta_id" value="<?= $conta_id ?>" type="hidden">
        <input type="submit" value="Sim, excluir">
    </form>

    <br><br>

    <h3><a href="conta.php?id=<?= $conta_id ?>">Não, voltar</a></h3>
    
<?php        
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<?php
include("footer.php");
?>
